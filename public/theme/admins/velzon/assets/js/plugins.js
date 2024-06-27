// (
//     document.querySelectorAll("[toast-list]")||document.querySelectorAll("[data-choices]")||document.querySelectorAll("[data-provider]"))&&(document.writeln("<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'><\/script>"),
//     document.writeln(`<script type='text/javascript' src='${PATH_ROOT}/assets/libs/choices.js/public/assets/scripts/choices.min.js'><\/script>`),
//     document.writeln(`<script type='text/javascript' src='${PATH_ROOT}/assets/libs/flatpickr/flatpickr.min.js'><\/script>`)
// );

// Tạo một thẻ script và thiết lập thuộc tính src
var script1 = document.createElement('script');
script1.src = 'https://cdn.jsdelivr.net/npm/toastify-js';
document.body.appendChild(script1); // Thêm script vào body của tài liệu

// Tương tự cho các script khác
var script2 = document.createElement('script');
script2.src = `${PATH_ROOT}/assets/libs/choices.js/public/assets/scripts/choices.min.js`;
document.body.appendChild(script2);

var script3 = document.createElement('script');
script3.src = `${PATH_ROOT}/assets/libs/flatpickr/flatpickr.min.js`;
document.body.appendChild(script3);

