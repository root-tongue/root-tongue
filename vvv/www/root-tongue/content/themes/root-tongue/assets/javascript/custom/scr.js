// fullpage customization
jQuery('#fullpage').fullpage({
  sectionSelector: '.vertical-scrolling',
  navigation: true,
  slidesNavigation: false,
  controlArrows: false,
  anchors: ['firstSection', 'secondSection', 'thirdSection', 'fourthSection'],
keyboardScrolling: false,
scrollOverflow:false,
verticalCentered: false,
});
//$.fn.fullpage.setAllowScrolling(false);