$('#add_cart').on('click',(event) => {
    // ajout au panier
    $.getJSON($(event.currentTarget).data('url'), {quantity : 1})
    .done((data) => {
        if(data.statut == 'ok') {
            $("#cart-header-nb").text(data.nb_product);
            for(let i = 0; i < 4; i++) {
                $( "#cart-header" ).animate({top: 70 }, 'medium').animate({top: 0 }, 'medium');
            }
        }
    })
});

$('[data-action="update_cart"]').on('click', (event) => {
    $.getJSON($(event.currentTarget).data('url'), {quantity : 1})
    .done((data) => {
        if(data.statut == 'ok') {
            $("#cart-header-nb").text(data.nb_product);
            if(data.statut == 'ok') {
                // si plus de produit on supprime la ligne
                if(data.current_nb_product <= 0 ) {
                    $('[data-target="'+data.current_slug+'"]').remove();
                } else {
                    $('.cart-qty','[data-target="'+data.current_slug+'"]').text(data.current_nb_product);
                    $('.cart-ttc','[data-target="'+data.current_slug+'"]').text(data.current_product_ttc);
                }
            }
        }
        if(data.nb_product <= 0) {
            $('#list_cart').hide();
            $('#cart_empty').show();
        }
    });
});