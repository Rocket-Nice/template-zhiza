if (!localStorage.getItem('cookieBanner')) {
  const banner = $('#cookie_banner');
  banner.show();

  $('#accept-cookie').on('click', function() {
    localStorage.setItem('cookieBanner', 'true');
    banner.hide();
  });
}
