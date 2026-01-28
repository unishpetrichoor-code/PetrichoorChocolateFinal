<footer class="text-center py-4 mt-5">
  <div class="container">
    <p class="mb-0">&copy; <?php echo date("Y"); ?> بتريشور شوكولاتة. جميع الحقوق محفوظة</p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Shrink navbar on scroll -->
<script>
window.addEventListener('scroll', function() {
  const navbar = document.querySelector('.navbar');
  if (window.scrollY > 50) {
    navbar.classList.add('scrolled');
  } else {
    navbar.classList.remove('scrolled');
  }
});
</script>

<!-- Scroll to Top -->
<script>
function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
