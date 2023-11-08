var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
})

$(function (){
    initTooltip()
})
function initTooltip(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
}
function initEditor(id){
    const editor = new FroalaEditor("#" + id, {
        imageUploadParam: 'image',
        attribution: false,
        key: 'kRB4zC1D1F2B1wobbd1bB-13wD1bH-8jC10D7D5B4B2A3H4E2A2B4==',
        imageUploadURL: "https://old.colorme.vn/api/v3/upload-image-public",
        fontSize: false,
        fontFamily: false,
        imageDefaultWidth: 'unset'
        // editorClass: 'product-content'
    });

    return editor;
}
function trans(element, rate) {
    var parent = element;
    while (!parent.classList.contains('container')) {
        parent = parent.parentElement;
    }
    var difference = window.pageYOffset - parent.offsetTop;
    if (difference > -500) {
        var velocity = difference * rate;
        element.style.transform = 'translate3d(0px, ' + velocity + 'px,0px)';
    }

};
window.addEventListener('scroll', function (e) {
    var scrolled = window.pageYOffset;
    var elements = document.querySelectorAll('.scroll-vertical-up-md');
    for (var i = 0; i < elements.length; i++) {
        trans(elements[i], -0.5);
    }
});
function formatPrice(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
function quickToastMixin(option, title) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,

        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    Toast.fire({
        icon: option,
        title: title
    })
}
function confirmDelete(config = {
    title: "Bạn có chắc chắn muốn xóa?",
    description: "Dữ liệu của bạn sẽ không thể khôi phục"
}, callback) {
    //add keyup
    $(document).on('keypress.key13', function (e) {
        if (e.which == 13) {
            $("#confirm-delete").trigger('click')
        }
    });

    //show swal confirm
    Swal.fire({
        title: config.title,
        text: ``,
        html: `${config.description} <br><span class='text-gray'>(Nhấn Enter để xác nhận)</span>`,
        confirmButtonColor: 'rgb(197, 0, 0)',
        confirmButtonText: `<i id="confirm-delete" class="fas fa-trash me-lg-2"></i> Xóa`
    })
        .then((result) => {
            $(document).unbind("keypress.key13");
            if (result.isConfirmed) {
                callback()
            }
        })
}
function initDropdownSelect(callback = undefined) {
    $.each($(".dropdown-select .dropdown-item,.dropdown-option"), function () {
        $(this).click(function (e) {
            const text = $(e.currentTarget).html();
            const value = $(e.currentTarget).data('value');
            const print = (($(this).closest(".dropdown-select").find(".print")).length)
                ? ($(this).closest(".dropdown-select").find(".print")).eq(0)
                : ($(this).closest(".dropdown-select").find(".dropdown-toggle")).eq(0)
            $(print).html(text);
            $(print).data('value', value);
            $(this).closest(".dropdown-select").find(".dropdown-item").removeClass('active');
            $(this).addClass('active');
            callback(this);
        })
    })

    if ($(".dropdown-select .dropdown-item.active").length) {
        $(".dropdown-select .dropdown-item.active").trigger('click')
    }
}
