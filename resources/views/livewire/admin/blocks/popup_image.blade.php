

<script>
    // Hàm hiển thị popup với hình ảnh từ URL
    function showImagePopup(imageUrl) {
            var popup = document.getElementById('imagePopup');
            var image = document.getElementById('popupImage');

            // Thiết lập src cho thẻ img trong popup
            image.src = imageUrl;

            // Hiển thị popup
            popup.style.display = 'block';
        }

        // Đóng popup khi người dùng nhấn vào nó
        document.getElementById('imagePopup').addEventListener('click', function() {
            this.style.display = 'none';
        });
</script>