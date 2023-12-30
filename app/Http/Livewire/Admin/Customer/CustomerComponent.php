<?php

namespace App\Http\Livewire\Admin\Customer;

use DB;
use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Address;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\AddressCity;
use App\Models\AddressWard;
use App\Models\AddressDistrict;
use App\Http\Livewire\Admin\BaseComponent;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerComponent extends BaseComponent
{
    use AuthorizesRequests;

    public $cities = [];
    public $districts = [];
    public $wards = [];
    public $address;
    public $address_city_id;
    public $address_district_id;
    public $address_ward_id;
    public $city_iteration = 0;
    public $district_iteration = 0;
    public $ward_iteration = 0;

    public function rules()
    {
        return [
            'object.id' => 'nullable',
            'object.presentation_name' => 'required|min:6',
            'object.company_name' => 'nullable|required_with:object.tax_no',
            'object.tax_no' => 'nullable|required_with:object.company_name',
            'object.email' => 'nullable|email::rfc,dns|required_with:object.company_name,object.tax_no',
            'object.note' => 'nullable',
            'object.phone' => ['nullable', 'regex:/^(\+84|0)([0-9]{9,10})$/'],
            'object.is_active' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'object.presentation_name.required' => 'Vui lòng nhập tên khách hàng.',
            'object.presentation_name.min' => 'Tên khách hàng phải có ít nhất 6 ký tự.',
            'object.phone.required' => 'Vui lòng nhập số điện thoại.',
            'object.phone.regex' => 'Số điện thoại không hợp lệ. Hãy nhập số điện thoại Việt Nam.',
            'object.company_name.required_with' => 'Trường Công ty là bắt buộc khi có mã số thuế.',
            'object.tax_no.required_with' => 'Trường Mã số thuế là bắt buộc khi có Tên Công ty.',
            'object.email.required_with' => 'Trường email là bắt buộc khi có Tên Công ty hoặc Mã số thuế.',
            // Thêm các thông báo lỗi tùy chỉnh cho các quy tắc khác nếu cần.
        ];
    }

    public function render()
    {
        $this->authorize('index', new Customer());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new Customer();
        $this->type = 'customer';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        $this->files = $this->getFiles();
        $pars = [
            'searchField' => 'presentation_name',
            'keyword' => $this->keyword,
            'sortBy' => $this->sortBy,
            'sortType' => $this->sortType,
            'limit' => $this->limit,
        ];

        // filter
        // if ($this->parent != null) {
        //     $pars['category_id'] = $this->parent;
        // }
        // if ($this->price_range != null) {
        //     $pars['price_range'] = $this->price_range;
        // }

        $data = $this->sysData->getData($this->model, $pars);
        $this->cities = AddressCity::select('id', 'name')->get()->toArray();
        $addresses = null;
        if (optional($this->object)->id) {
            $addresses = $this->object->addresses;
        }

        $dataToView = [
            'data' => $data,
            'links' => $data->links() ?? null,
            'addresses' => $addresses,
        ];

        $this->checkPermission();

        return view($this->view, $dataToView)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }

    /**
     * Method getDistrictData
     * Khi thành phố được chọn từ JS sẽ gọi đến phương thức này để cập nhật danh sách quận.
     * Gọi sự kiện select2_intial để thiết lập lại select2 cho quận và phường
     * $this->iteration++ mục đích để render danh sách đang được wire:ignore
     * @param $city_id $city_id [id của thành phố được chọn]
     *
     * @return void
     */
    public function getDistrictData($city_id)
    {
        if ($city_id) {
            $this->wards = [];
            $this->districts = AddressDistrict::where('address_city_id', $city_id)->get()->toArray();

            // Khởi tạo lại Select2 cho thẻ select của quận huyện và phường xã
            $this->emit('select2_intial');

            $this->district_iteration++;
            $this->ward_iteration++;
        }
    }

    public function getWardData($district_id)
    {
        if ($district_id) {
            $this->wards = AddressWard::where('address_district_id', $district_id)->get()->toArray();

            // Khởi tạo lại Select2 cho thẻ select của phường xã
            $this->emit('select2_district', $district_id);

            $this->ward_iteration++;
        }
    }

    public function addAddress()
    {
        $this->validate([
            'address' => 'required|min:6',
            'address_city_id' => 'required|integer',
            'address_district_id' => 'required|integer',
            'address_ward_id' => 'required|integer',
        ], [
            'address.required' => 'Vui lòng cung cấp địa chỉ.',
            'address.min' => 'Địa chỉ phải có ít nhất 6 ký tự.',
            'address_city_id.required' => 'Vui lòng chọn tỉnh/thành phố.',
            'address_district_id.required' => 'Vui lòng chọn quận/huyện.',
            'address_ward_id.required' => 'Vui lòng chọn phường xã.',
            'address_city_id.integer' => 'Vui lòng chọn tỉnh/thành phố.',
            'address_district_id.integer' => 'Vui lòng chọn quận/huyện.',
            'address_ward_id.integer' => 'Vui lòng chọn phường xã.',
        ]);

        DB::beginTransaction();

        try {
            if ($this->address && $this->address_city_id && $this->address_district_id && $this->address_ward_id) {
                $newAddress = [
                    'address' => $this->address,
                    'address_city_id' => $this->address_city_id,
                    'address_district_id' => $this->address_district_id,
                    'address_ward_id' => $this->address_ward_id,
                ];
                $address = Address::create($newAddress);

                // Thiết lập relationship
                $this->object->addresses()->attach($address);

                DB::commit();

                $this->emit('notification_update_success');

                // thiết lập giá trị mặc định
                $this->reset('address', 'cities', 'districts', 'wards', 'address_city_id', 'address_district_id', 'address_ward_id');

                // Khởi tạo lại Select2 cho thẻ select của quận huyện và phường xã
                $this->emit('select2_intial');

                // Mở khóa cho phép cập nhật data của quận huyện và phường xã
                $this->district_iteration++;
                $this->ward_iteration++;
                $this->city_iteration++;

                $this->emit('refreshComponent');
                
            } else {
                $this->emit('notification_error');
            }
        } catch (\Exception $th) {
            DB::rollback();
            $this->emit('notification_error');

            throw $th;
        }
    }

    public function removeAddress($id)
    {
        DB::beginTransaction();

        try {
            if ((int) $id) {
                $address = Address::find($id);
                if ($address->checkBeforeDelete()) {
                    $address::destroy($id);
                    DB::commit();
                }else{
                    throw new Exception('Không thể xóa địa chỉ này!');
                }
                
            }
            $this->emit('notification_update_success');

            $this->emit('refreshComponent');
        } catch (\Throwable $th) {
            $this->emit('notification_error', $th->getMessage());

            //throw $th;
        }
    }
}
