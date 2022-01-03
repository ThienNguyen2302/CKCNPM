let selectedProduct;
$(document).ready(function () {
    loadData();

    $("#delete-product").click(function () {
        console.log(selectedProduct)
        // $.post("http://localhost/lab08/delete_product.php", selectedProduct.id,function(data, status) {  
        //     if(status) {
        //         loadData();
        //     }

        // });

    });
    
});

function getID(e) {
    let productInfoStr = $(e.parentNode.parentNode).attr('data'),
    selectedProduct = JSON.parse(productInfoStr)
    $('.modal-body strong').text(selectedProduct.name)
    console.log(selectedProduct)
}

function loadData() {
    $.get("http://localhost/lab08/read_product.php", function(data) {  
        data = JSON.parse(data)
        if(data.status) {
            $('.item').remove()
            data.data.forEach(product => {
                let productRow =  $('<tr class="item">'),
                    id =  $('<td>'),
                    img = $('<img>'),
                    name =  $('<td>'),
                    price =  $('<td>'),
                    desc =  $('<td>'),
                    delbtn  = $('<a href="#" data-toggle="modal" data-target="#myModal" onclick = "getID(this)" class="">Đặt Hàng</a>'),
                    action =  $('<td>');
                productRow.attr('data',JSON.stringify(product));
                img.attr('src',"images/" + product.image);
                id.append(img);
                name.text(product.name);
                price.text(product.price);
                desc.text(product.description);
                action.append(delbtn)
                productRow.append(id,name,price,desc,action);
                console.log(productRow)
                $('table').append(productRow);
            });
            let row = $('<tr class="control" style="text-align: right; font-weight: bold; font-size: 17px">')
            let td = $('<td colspan="5">')
            let p = $('<p></p>')
            p.text("Số lượng sản phẩm: " + data.data.length)
            td.append(p)
            row.append(td)
            $('table').append(row)
        }
    })
}
