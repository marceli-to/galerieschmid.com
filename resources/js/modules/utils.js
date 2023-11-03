(function() {
  const privacyButton = document.querySelector('[data-toggle-privacy]');
  const privacyText = document.querySelector('[data-privacy]');

  // Toggle privacy text
  if (privacyButton && privacyText) {
    privacyButton.addEventListener('click', () => {
      privacyText.classList.toggle('is-hidden');
    });
  }
})();
