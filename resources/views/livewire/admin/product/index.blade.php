@section('title', 'Product')
<div>
    @if (!$isForm)
        @include('livewire.admin.' . $type . '.list')
    @else
        @include('livewire.admin.' . $type . '._form')
    @endif

    {{-- files modal --}}
    @include('livewire.admin.blocks.file-modal', [
        'idModal' => 'image-list',
        'files' => $this->files,
        'field' => 'file_id',
    ])

    @include('livewire.admin.blocks.file-modal', [
        'idModal' => 'description',
        'files' => $this->files,
    ])

    {{-- @include('livewire.admin.blocks.popup_image') --}}
</div>

<!-- Tạo một thẻ div để hiển thị popup -->
<div class="image-popup" id="imagePopup">
    <div class="popup-content">
        <img id="popupImage" src="" alt="Popup Image">
    </div>
</div>
<style>
/* CSS cho popup */
.image-popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        text-align: center;
        z-index: 9999;
       
    }

    .popup-content {
        max-width: 80%;
        max-height: 80%;
        margin: 10% auto;
        animation: zoomIn 0.3s forwards; /* Hiệu ứng zoom in */
    }

    /* Keyframes cho hiệu ứng zoom in */
    @keyframes zoomIn {
        from {
            transform: scale(0.5);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* CSS cho nút tắt popup */
    .close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        background-color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
    }
</style>
@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on('isForm', postId => {
                $('#categories').select2();
                $('#categories').on('change', function(e) {
                    let data = $(this).select2("val");
                    @this.set('categories', data);
                });
            });
        });
    </script>
@endpush
