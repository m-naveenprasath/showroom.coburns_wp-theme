document.addEventListener("DOMContentLoaded", function () {
    const featuredProductWidgets = document.querySelectorAll('[id^="featuredProductsWidget"]');
    if (featuredProductWidgets) {
      featuredProductWidgets.forEach(widget => {
        const WidgetId = widget.getAttribute('id');
        const featuredProductTag = widget.getAttribute('data-filter');
        const FilterLabel = widget.getAttribute('data-filter-label');
        const payLoad = widgetPayload(featuredProductTag,FilterLabel);
        getWidgets(payLoad, WidgetId)
      })
  
    }
  
    function widgetPayload(featuredProductTag="", FilterLabel="") {
      if (!featuredProductTag) {
        return {}
      }
      return {
        "WidgetKey": "e002f354-ce0a-4102-8551-1e3aa41cbd92",
        "ListType": "Undefined",
        "MaxResults": 8,
        "MinReviewScore": "0.0",
        "SortType": "New",
        "IncludeCustomFields": true,
        "IncludeChildren": "true",
        "IncludeUnavailable": "true",
        "PageSize": 8,
        "PageNumber": 0,
        "FilterGroups": [{
          "Filters": [{
            "isCustom": false,
            "MinValue": `${featuredProductTag}`,
            "MaxValue": `${featuredProductTag}`,
            "FilterLabel": `${FilterLabel}`,
            "Id": "attributegroups5"
          }],
          "GroupType": "AttributeGroup",
          "Title": "Top Brands"
        }],
        "Platform": "AmeriCommerce",
        "updatingMessage": "Updating..."
      }
    }
  
    function getWidgets(payLoad, WidgetId) {
  
      jQuery.ajax({
        url: 'https://shopcoburns.cartsync.com/api/Utilities/GetContentWidget',
        method: 'POST',
        data: payLoad,
        async: true
      }).done(function (data) {
        if(!data){
          jQuery(`#${WidgetId}`).parent().closest('.product-feature-container').remove();
        }
  
        jQuery(`#${WidgetId}`).html(data);
  
      });
    }
  
  })
  