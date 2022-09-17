jQuery(document).ready(function ($) {
  /**
   * Add custom class
   */
  $('.rpwe-options').closest('.widget-inside').addClass('rpwe-bg')

  /**
   * Tabs
   */
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
    console.log(activeTab)
    $(`${activeTab}.rpwe-tab-content`).fadeIn()
    return false
  })
})
