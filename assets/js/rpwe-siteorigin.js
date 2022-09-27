;(function ($) {
  function rpwe_siteorigin_custom_bg_class() {
    $('.rpwe-options').closest('.so-content').addClass('rpwe-bg')
  }

  function rpwe_siteorigin_custom_tabs() {
    // Show the first tab and hide the rest.
    $('#rpwe-tabs-nav li:first-child').addClass('active')
    $('.rpwe-tab-content').hide()
    $('.rpwe-tab-content:first-child').show()

    // Click the navigation.
    $('body').on('click', '#rpwe-tabs-nav li', function (e) {
      e.preventDefault()

      $('#rpwe-tabs-nav li').removeClass('active')
      $(this).addClass('active')
      $('.rpwe-tab-content').hide()

      const activeTab = $(this).find('a').attr('href')
      $(`${activeTab}.rpwe-tab-content`).show()
      return false
    })
  }

  $(document).on('panelsopen', function (e) {
    rpwe_siteorigin_custom_bg_class()
    rpwe_siteorigin_custom_tabs()
  })
})(jQuery)
