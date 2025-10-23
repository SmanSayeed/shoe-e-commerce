  <!-- Footer -->
  <footer class="bg-slate-900 text-slate-200">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <div class="flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded bg-amber-600 text-white font-black">SSB</span>
            <div>
              <span class="font-extrabold text-lg tracking-tight block">SSB Leather</span>
              <p class="text-xs text-slate-400">Premium leather goods — crafted to last.</p>
            </div>
          </div>
          <p class="mt-4 text-sm text-slate-400">Shop confidently with secure checkout and nationwide shipping. Need help? Our support team is ready.</p>
        </div>

        <div>
          <h4 class="font-semibold text-base">Contact</h4>
          <ul class="mt-3 space-y-2 text-sm text-slate-300">
            <li><a href="mailto:support@ssbleather.com" class="hover:text-white">support@ssbleather.com</a></li>
            <li><a href="tel:+8809610957957" class="hover:text-white">09610‑957957</a></li>
            <li class="text-slate-400">Banani, Dhaka, Bangladesh</li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold text-base">Account</h4>
          <ul class="mt-3 space-y-2 text-sm text-slate-300">
            <li><a class="hover:text-white" href="#">Dashboard</a></li>
            <li><a class="hover:text-white" href="#">Orders</a></li>
            <li><a class="hover:text-white" href="#">Wishlist</a></li>
            <li><a class="hover:text-white" href="#">Privacy Policy</a></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold text-base">Newsletter</h4>
          <p class="mt-2 text-sm text-slate-400">Get product updates and exclusive offers — no spam.</p>
          <form class="mt-3 flex gap-2" onsubmit="event.preventDefault(); alert('Subscribed');">
            <label for="footer-email" class="sr-only">Email address</label>
            <input id="footer-email" type="email" required placeholder="Your email" class="w-full rounded-md border-0 px-3 py-2 text-slate-800 focus:ring-2 focus:ring-amber-500" />
            <button class="px-4 py-2 rounded-md bg-amber-600 text-white font-semibold hover:bg-amber-700">Join</button>
          </form>

          <div class="mt-4 flex items-center gap-3 text-slate-300">
            <a href="#" aria-label="facebook" class="hover:text-white" title="Facebook">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.99H7.898v-2.89h2.54V9.845c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.89h-2.33v6.99C18.343 21.128 22 16.991 22 12z"/></svg>
            </a>
            <a href="#" aria-label="instagram" class="hover:text-white" title="Instagram">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm8 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10z"/></svg>
            </a>
            <a href="#" aria-label="twitter" class="hover:text-white" title="Twitter">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 5.924c-.69.307-1.432.513-2.208.605.794-.476 1.404-1.23 1.692-2.131-.743.44-1.567.76-2.444.933-.703-.75-1.71-1.216-2.823-1.216-2.136 0-3.868 1.732-3.868 3.868 0 .303.034.598.1.883-3.214-.161-6.066-1.7-7.979-4.041-.333.574-.524 1.242-.524 1.953 0 1.35.687 2.54 1.732 3.237-.638-.02-1.238-.196-1.763-.488v.049c0 1.884 1.34 3.456 3.118 3.813-.326.088-.669.136-1.023.136-.25 0-.493-.025-.73-.07.494 1.543 1.927 2.665 3.624 2.698-1.328 1.04-2.998 1.66-4.814 1.66-.313 0-.623-.018-.93-.053 1.717 1.101 3.755 1.743 5.947 1.743 7.135 0 11.04-5.913 11.04-11.04 0-.168-.004-.335-.012-.5.758-.547 1.415-1.23 1.934-2.01-.693.307-1.437.513-2.208.605z"/></svg>
            </a>
          </div>
        </div>
      </div>

      <div class="mt-8 border-t border-white/10 pt-4 text-xs text-slate-400">
        <div class="text-center">
          <p class="mb-2">© <span id="year"></span> SSB Leather. All rights reserved.</p>
          <div class="flex items-center justify-center gap-3">
            <a href="#" class="hover:text-white">Terms</a>
            <span class="text-slate-600">·</span>
            <a href="#" class="hover:text-white">Privacy</a>
          </div>
        </div>
      </div>
    </div>
    <script>document.getElementById('year').textContent = new Date().getFullYear();</script>
  </footer>