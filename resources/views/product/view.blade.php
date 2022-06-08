@extends('layouts.app')

@section('seo_title', $seoTitle)
@section('meta_description', $metaDescription)
@section('meta_keywords', $metaKeywords)

@section('microdata')
{!! $microdata !!}
@endsection

@section('content')

<main class="main product-page-container">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    @include('product.partials.product_page_content')

    <x-similar-products :product-id="$product->id"></x-similar-products>

    <x-bestseller-products></x-bestseller-products>

</main>

@endsection

@section('after_footer_blocks')
<div class="modal fade" id="not-in-stock-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="mb-3">
                        {{ __('main.product_not_in_stock') }}
                    </h4>
                    <button type="button" class="btn btn-secondary mb-2" data-dismiss="modal">
                        {{ __('main.continue_shopping') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    $(function() {

        let productID = $('.product-page-content').data('product-id');

        // theme specific
        $('body').on('click', '.show-all-specifications-btn', function () {
            $('[href="#product-characteristics"]').trigger('click');
            $("html, body").animate({
                scrollTop: $('#product-descr-container').offset().top - 100,
            }, 600);
        })
        // end theme specific


        // product group
        // set proper attribute values
        if ($('.product-group-item').length) {
            // setCheckedAttributeValues();
            updateAvailableAttributeValues();
        }
        $('body').on('click', '.product-group-attribute-value-label', function(){
            let input = $('#' + $(this).attr('for'));
            if (input.prop('checked')) {
                input.prop('checked', false);
                updateAvailableAttributeValues();
                return false;
            }
        })
        $('body').on('change', '.product-group-attribute-value-input', function(){
            let activeValues = $('.product-group-attribute-value-input:checked');
            let activeValuesIDs = [];
            activeValues.each(function(){
                activeValuesIDs.push(+$(this).val());
            });
            let combination = activeValuesIDs.sort((a,b) => a-b).join('-');
            let productGroupItem = $('.product-group-item[data-combination="' + combination + '"]');
            if (!productGroupItem.length) {
                updateAvailableAttributeValues();
                return;
            }
            $.ajax({
                url: productGroupItem.data('url'),
                dataType: 'json',
                beforeSend: function () {
                    $('.page-preloader').addClass('active');
                }
            })
                .done(function(data){
                    $('.product-page-container').html(data.main);
                    $('title').text(data.seo_title);
                    $('meta[name="description"]').text(data.meta_description);
                    $('meta[name="keywords"]').text(data.meta_keywords);
                    history.replaceState({
                        id: 'product-' + data.product_id,
                        source: 'web'
                    }, data.seo_title, data.product_url);
                    updateAvailableAttributeValues();
                })
                .always(function(){
                    $('.page-preloader').removeClass('active');
                });
        });
        function setCheckedAttributeValues() {
            let activeProductGroupItem = $('.product-group-item[data-product-id="' + productID + '"]');
            let combination = activeProductGroupItem.data('combination');
            let attributeValueIDs = combination.split('-').map(value => +value);
            for (let attributeValueID of attributeValueIDs) {
                $('.product-group-attribute-value-input[value="' + attributeValueID + '"]').prop('checked', true);
            }
        }
        function updateAvailableAttributeValues() {
            let attributes = $('.product-group-attribute');
            if (attributes.length == 1) {
                    let someInputChecked = false;
                    let currentAttribute = attributes.eq(0);
                    let currentAttributeInputs = currentAttribute.find('.product-group-attribute-value-input:not(:checked)');
                    currentAttributeInputs.each(function(){
                        let productGroupItemFound = false;
                        let combination = +$(this).val();
                        let productGroupItem = $('.product-group-item[data-combination="' + combination + '"]');
                        if (productGroupItem.length && +productGroupItem.data('in-stock') > 0) {
                            productGroupItemFound = true;
                        }
                        productGroupItemFound ? $(this).prop('disabled', false) : $(this).prop('disabled', true);
                    })
            } else if (attributes.length == 2) {
                let someInputChecked = false;
                attributes.each(function(){
                    let currentAttribute = $(this);
                    let currentAttributeID = currentAttribute.data('attribute-id');
                    let selectedAttributeValue = currentAttribute.find('.product-group-attribute-value-input:checked');
                    if (!selectedAttributeValue.length) {
                        return;
                    }
                    let selectedAttributeValueID = +selectedAttributeValue.val();
                    someInputChecked = true;
                    let beingCheckedAttribute = $('.product-group-attribute:not([data-attribute-id="' + currentAttributeID + '"])');
                    let beingCheckedAttributeInputs = beingCheckedAttribute.find('.product-group-attribute-value-input:not(:checked)');
                    beingCheckedAttributeInputs.each(function(){
                        let productGroupItemFound = false;
                        let combination = [selectedAttributeValueID, +$(this).val()].sort((a,b) => a-b).join('-');
                        let productGroupItem = $('.product-group-item[data-combination="' + combination + '"]');
                        if (productGroupItem.length && +productGroupItem.data('in-stock') > 0) {
                            productGroupItemFound = true;
                        }
                        productGroupItemFound ? $(this).prop('disabled', false) : $(this).prop('disabled', true);
                    })
                });
                if (!someInputChecked) {
                    $('.product-group-attribute-value-input').prop('disabled', false);
                }
            } else if (attributes.length == 3) {
                let checkedAttributeValues = $('.product-group-attribute-value-input:checked');
                if (checkedAttributeValues.length == 3) {
                    attributes.each(function() {
                        let attribute = $(this);
                        let attributeID = attribute.data('attribute-id');
                        let otherAttributesCheckedAttributeValuesIDs = [];
                        let otherAttributesCheckedAttributeValues = $('.product-group-attribute:not([data-attribute-id="' + attributeID + '"])').find('.product-group-attribute-value-input:checked');
                        otherAttributesCheckedAttributeValues.each(function(){
                            otherAttributesCheckedAttributeValuesIDs.push(+$(this).val());
                        })
                        let notCheckedValues = $(this).find('.product-group-attribute-value-input:not(:checked)');
                        notCheckedValues.each(function(){
                            let combination = [+$(this).val(), otherAttributesCheckedAttributeValuesIDs[0], otherAttributesCheckedAttributeValuesIDs[1]];
                            let productGroupItem = $('.product-group-item[data-combination="' + combination + '"]');
                            (productGroupItem.length && +productGroupItem.data('in-stock') > 0) ? $(this).prop('disabled', false) : $(this).prop('disabled', true);
                        })
                    })
                } else if (checkedAttributeValues.length == 2) {
                    attributes.each(function() {
                        let attribute = $(this);
                        let attributeID = attribute.data('attribute-id');
                        let currentAttributeCheckedAttributeValue = attribute.find('.product-group-attribute-value-input:checked');
                        if (!currentAttributeCheckedAttributeValue.length) {
                            let otherAttributesCheckedAttributeValuesIDs = [];
                            let otherAttributesCheckedAttributeValues = $('.product-group-attribute:not([data-attribute-id="' + attributeID + '"])').find('.product-group-attribute-value-input:checked');
                            otherAttributesCheckedAttributeValues.each(function(){
                                otherAttributesCheckedAttributeValuesIDs.push(+$(this).val());
                            })
                            let currentAttributeValues = attribute.find('.product-group-attribute-value-input');
                            currentAttributeValues.each(function(){
                                let combination = [+$(this).val(), otherAttributesCheckedAttributeValuesIDs[0], otherAttributesCheckedAttributeValuesIDs[1]].sort((a,b) => a-b).join('-');
                                let productGroupItem = $('.product-group-item[data-combination="' + combination + '"]');
                                (productGroupItem.length && +productGroupItem.data('in-stock') > 0) ? $(this).prop('disabled', false) : $(this).prop('disabled', true);
                            })
                        } else {
                            let currentAttributeCheckedAttributeValueID = +currentAttributeCheckedAttributeValue.val();
                            let otherAttributes = $('.product-group-attribute:not([data-attribute-id="' + attributeID + '"])');
                            let otherAttributesCheckedAttributeValue = otherAttributes.find('.product-group-attribute-value-input:checked');
                            let otherAttributesCheckedAttributeValueID = +otherAttributesCheckedAttributeValue.val();
                            let currentAttributeNotCheckedValues = attribute.find('.product-group-attribute-value-input:not(:checked)');
                            currentAttributeNotCheckedValues.each(function(){
                                let combination = [+$(this).val(), currentAttributeCheckedAttributeValueID, otherAttributesCheckedAttributeValueID].sort((a,b) => a-b).join('-');
                                let productGroupItem = $('.product-group-item[data-combination="' + combination + '"]');
                                (productGroupItem.length && +productGroupItem.data('in-stock') > 0) ? $(this).prop('disabled', false) : $(this).prop('disabled', true);
                            })
                        }
                    })
                } else if (checkedAttributeValues.length == 1) {
                    attributes.each(function() {
                        let attribute = $(this);
                        let attributeID = attribute.data('attribute-id');
                        let currentAttributeCheckedAttributeValue = attribute.find('.product-group-attribute-value-input:checked');
                        if (currentAttributeCheckedAttributeValue.length) {
                            let currentAttributeCheckedAttributeValueID = +currentAttributeCheckedAttributeValue.val();
                            let otherAttributes = $('.product-group-attribute:not([data-attribute-id="' + attributeID + '"])');
                            otherAttributes.each(function(){
                                let secondAttribute = $(this);
                                let secondAttributeID = secondAttribute.data('attribute-id');
                                let secondAttributeValues = secondAttribute.find('.product-group-attribute-value-input');
                                secondAttributeValues.each(function(){
                                    let secondCurrentAttributeValue = $(this);
                                    let secondCurrentAttributeValueID = +secondCurrentAttributeValue.val();
                                    let productItemFound = false;
                                    let thirdAttribute = $('.product-group-attribute:not([data-attribute-id="' + attributeID + '"], [data-attribute-id="' + secondAttributeID + '"])');
                                    let thirdAttributeID = thirdAttribute.data('attribute-id');
                                    let thirdAttributeValues = thirdAttribute.find('.product-group-attribute-value-input');
                                    thirdAttributeValues.each(function(){
                                        let combination = [+$(this).val(), currentAttributeCheckedAttributeValueID, secondCurrentAttributeValueID].sort((a,b) => a-b).join('-');
                                        let productGroupItem = $('.product-group-item[data-combination="' + combination + '"]');
                                        if (productGroupItem.length && +productGroupItem.data('in-stock') > 0) {
                                            productItemFound = true;
                                        }
                                    })
                                    productItemFound ? $(this).prop('disabled', false) : $(this).prop('disabled', true);
                                })
                            })
                        } else {
                            //
                        }
                    })
                } else {
                    $('.product-group-attribute-value-input').prop('disabled', false);
                }
            }
        }
    });

</script>

@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
@endsection
