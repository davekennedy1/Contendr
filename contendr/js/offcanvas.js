$(function() {
'use strict'

$(document)
  .on('click', '[data-toggle="offcanvas"]', function(e) {
    $('.offcanvas-collapse').toggleClass('open'); // toggle `.open`
    e.stopPropagation(); // and stop propagation
  })
 .on('click', function(e) {
 if (!$(e.target).closest('nav.fixed-top').is('nav')) {
   $('.offcanvas-collapse').removeClass('open'); // remove `.open`
 }
});
})
