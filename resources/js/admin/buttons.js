$(document).ready(function () {
    $('button.delete').click(function () {
        const route = $(this).attr('route')
        const buttonDelete = $(this)
        Swal.fire({
            title: 'Do you want to delete this record?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: `No I changed`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                buttonDelete.parent().parent().hide('slow')
                axios
                    .delete(route)
                    .then((response) => {
                        //console.log(response.data)
                        Swal.fire('Deleted!', '', 'success')
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    })

    $('button[name=exit-form]').click(function () {
        const target = $(this).attr('target')

        Swal.fire({
            title: 'Do you want to exit?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: `No I changed`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                location.replace(target)
            } else if (result.isDenied) {
                return false
            }
        })
    })


    // Check info tax
    $('#check-tax-info').click(function () {
        const taxNo = $('input[name=tax_no]').val()
        const route = $('input[name=tax_route]').val()
        if (!taxNo) return
        axios
            .post(route, { mst: taxNo })
            .then(function (response) {
                if (response.data.ChuSoHuu != null) {
                    $('input[name=presentation_name]').val(response.data.ChuSoHuu)
                    $('input[name=company_name]').val(response.data.Title)
                    $('input[name=address]').val(response.data.DiaChiCongTy)
                } else {
                    alert('Mã số thuế không tìm thấy')
                }

                console.log(response)
            })
            .catch(function (error) {
                console.log(error)
            })
    })
});