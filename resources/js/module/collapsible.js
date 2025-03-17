// Lấy danh sách tất cả các nút và phần nội dung
let clpButton = document.querySelectorAll('.clp-button');
let clpCnts = document.querySelectorAll('.clp-content');

clpButton.forEach(function(button, index) {
    button.addEventListener('click', function() {
        // Lấy phần nội dung tương ứng với nút được nhấp
        let content = clpCnts[index];

        if(content.style.display === 'none' || content.style.display === '' ) {
            content.style.display = 'flex';
        }
        else {
            content.style.display = 'none';
        }
    });
});




