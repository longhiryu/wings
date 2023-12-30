$(document).ready(function () {
    $('.product-search-result').hide()

    $('.product-search').keyup(function () {
        const keyword = $(this).val()
        const route = $(this).attr('route')
        if (keyword.length >= 3) {
            const data = {
                keyword: keyword,
            }

            axios
                .post(route, data)
                .then((response) => {
                    const html = response.data.map((item) => {
                        return (
                            '<div class="product-list-found" price="' +
                            item.price +
                            '" id="' +
                            item.id +
                            '">' +
                            item.translated.name +
                            '</div>'
                        )
                        // return (
                        //     <div class="product-list-found" price={item.price} id={item.id}>
                        //         {item.translated.name}
                        //     </div>
                        // )
                    })
                    $('.product-search-result').show()
                    $('.product-search-result').html(html)
                })
                .catch((error) => {
                    console.log(error)
                })
        }
    })

    $(document).on('click', '.product-list-found', function () {
        const name = $(this).html()
        const id = $(this).attr('id')
        const price = $(this).attr('price')
        $('input[name=product_name]').val(name)
        $('input[name=product_id]').val(id)
        $('input[name=product_price]').val(price)
        $('.product-search-result').hide()
    })

    $('.add-product').click(function () {
        const route = $('input[name=product_add]').val()
        const data = {
            product_id: $('input[name=product_id]').val(),
            product_name: $('input[name=product_name]').val(),
            product_price: $('input[name=product_price]').val(),
            product_quantity: $('input[name=product_quantity]').val(),
            product_unit: $('select[name=product_unit]').val(),
        }

        axios
            .post(route, data)
            .then((response) => {
                $('.product-list-table').html(response.data)
            })
            .catch((error) => {
                console.log(error)
            })
    })


    $(document).on('click', '.product-remove', function () {
        const product_id = $(this).parent('td').attr('product_id')
        const product_price = $(this).parent('td').attr('product_price')
        const product_quantity = $(this).parent('td').attr('product_quantity')
        const route = $(this).parent('td').attr('route')
        const data = {
            product_id: product_id,
            product_price: product_price,
            product_quantity: product_quantity,
        }

        axios
            .post(route, data)
            .then((response) => {
                $('.product-list-table').html(response.data)
            })
            .catch((error) => {
                console.log(error)
            })
    })


    $('.clear-product').click(function (e) {
        const route = $('input[name=product_clear]').val()
        Swal.fire({
            title: 'Do you want to delete this record?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: `No I changed`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios
                    .post(route)
                    .then((response) => {
                        //console.log(response.data)
                        Swal.fire('Cleared!', '', 'success')
                        $('.product-list-table').html('')
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    })
});