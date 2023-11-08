const cart = {
    cookie: {
        add: (data)=>{
            $.cookie('phoneStore', null, {path:'/'})
            $.cookie('phoneStore', JSON.stringify(data), {path:'/'})
        },
        get: () => {
            let data = $.cookie("phoneStore") ? JSON.parse($.cookie("phoneStore")) : [];
            return data;
        },
    },
    fetch: (list, callback)=>{
        $("#loadingCart").show()
        const rand = new Date();
        axios.get('/products/fetchList?id=' + JSON.stringify(list) + "&rand=" + rand)
        .then(r=>{
            console.log(r)
            $("#cartCheckout").attr('disabled',false)
            $("#loadingCart").hide()
            callback(r.data)
        })
        .catch(e=>{
            $("#cartCheckout").attr('disabled',true)
            quickToastMixin('error', 'Giỏ hàng của bạn rỗng');
            $("#cartPrintProducts").html('<div class="text-center mt-5">Giỏ hàng của bạn rỗng<br><a class="fw-bold text-gray cursor-pointer">Đặt hàng ngay</a></div>')
        })
        .finally(()=>{
            $("#loadingCart").hide()
        })
    },
    generate: (data)=>{
        return `<div data-product-id="${data.id}"
        class="card-cart card-product product px-5" data-id="${data.id}">
       <div class="d-flex my-4">
           <div class="me-3">
               <a href="/products/detail?id=${data.id}">
                   <img class="rounded-2 product-fixed-img"
                                            src="${data.first_image}"></a>
           </div>
           <div class="d-flex flex-column justify-content-between flex-fill">
               <div class="d-flex justify-content-between my-md-0">
                   <div>
                       <a href="/products/detail?id=${data.id}">
                           <div class="fs-6 fw-bold">${data.name}</div>
                       </a>
                       <div class="text-gray limit-3-line"><small>${data.description}</small></div>
                   </div>
                   <div onclick="cart.remove(${data.id})" class="cursor-pointer ms-4">
                       <i class="fa-solid fa-trash ms-3"></i>
                   </div>
               </div>
               <div class="d-flex justify-content-between align-items-center box-price">
                   <div><input onkeyup="cart.updateNumber(this);cart.updatePrice()" data-price="${data.price}" class="number-product form-control" type="number" value="1" style="width: 80px"/></div>
                   <small data-price="${data.price}" class="d-none d-md-block fw-bold ms-3 cart-product-price">${formatPrice(data.price)}đ</small>
               </div>
           </div>
       </div>
   </div>`
    },
    updateNumber: (self)=>{
        const numb = $(self).val();
        console.log(numb);
        const price = numb*($(self).data('price'));
        (($(self).closest('.box-price')).find(".cart-product-price")).html(formatPrice(price)+"đ").attr('data-price',price).data('price',price)
    },
    settingCartData: ()=>{
        var items = [];
        $.each($(".card-cart.product"), function(){
            let obj = {};
            obj.id = $(this).data('id');
            obj.numb = $(this).find(".number-product").val();
            obj.price = $(this).find(".cart-product-price").data('price');
            items.push(obj);
        })
        console.log(items)
        $("#productItemCheckout").val(JSON.stringify(items))
    },
    updatePrice: ()=>{
        var total=0;
        $.each($(".cart-product-price"), function(){
            total+=parseInt($(this).data('price'));
        })
        $("#cartTotalPrice").html(formatPrice(total)+"đ").data('price',total)
    },
    show: () => {
        const data = cart.cookie.get();
        console.log(data);
        $("#cartPrintProducts").html('')
        cart.fetch(data, function(data){    
            $.each(data, function(i,item){
                $("#cartPrintProducts").append(cart.generate(item));
                setTimeout(function(){
                    cart.updatePrice()
                },200)
            })
        })
    },
  
    checkout: (btn)=>{
        toastr.info('Đang tạo đơn hàng...')
        $(btn).html(`Đang tạo <div class="spinner-border spinner-border-sm" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>`)
        $(btn).attr('disabled',true)
        const data = cart.getCartData();
        cart.post(data, (res)=>{
            location.href = '/checkout'
        }, function (){
            $(btn).html(`Tiến hành thanh toán`)
            $(btn).attr('disabled',false)
        });
    },
    add: (id) => {
        const numb = parseInt($(".badge-numb-product").eq(0).text());
        const cookies = cart.cookie.get();
        const isLess = (cookies).every((item) => (item != id));
        if (isLess) {
            (cookies).push(id);
            cart.cookie.add(cookies);
            $(".badge-numb-product").html(numb + 1);
        }
        $(".cart-shopping").eq(0).trigger('click');
    },
    remove: (id) => {
        const numb = parseInt($(".badge-numb-product").eq(0).text());
        let cookies = cart.cookie.get();
        console.log(cookies)
        cookies = (cookies).filter((value) => (value != id));
        console.log(cookies)
        $(`.card-cart.product[data-product-id=${id}]`).remove();
        $(".badge-numb-product").html(numb - 1)
        cart.cookie.add(cookies);
        cart.updatePrice();
        quickToastMixin('success','Đã xoá sản phẩm khỏi giỏ hàng');
        cart.show();
    },
}
$(function () {
    const cookies = cart.cookie.get();
    console.log(cookies)
    if (cookies){
        const count = (cookies).length;
        $(".badge-numb-product").html(count)
    }
})

