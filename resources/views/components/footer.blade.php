  <!-- Footer -->
  <footer class="bg-slate-900 text-slate-200">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="grid md:grid-cols-4 gap-8">
        <div>
          <div class="flex items-center gap-2">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded bg-amber-600 text-white font-black">SSB</span>
            <span class="font-extrabold text-xl tracking-tight">SSB Leather</span>
          </div>
          <p class="mt-3 text-sm text-slate-400">Premium leather goods designed to last. Crafted with care and shipped nationwide.</p>
        </div>
        <div>
          <h4 class="font-semibold">Get in touch</h4>
          <ul class="mt-3 space-y-2 text-sm text-slate-300">
            <li>support@ssbleather.com</li>
            <li>09610‑957957</li>
            <li>Banani, Dhaka, Bangladesh</li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold">My Account</h4>
          <ul class="mt-3 space-y-2 text-sm text-slate-300">
            <li><a class="hover:text-white" href="#">Dashboard</a></li>
            <li><a class="hover:text-white" href="#">Orders</a></li>
            <li><a class="hover:text-white" href="#">Wishlist</a></li>
            <li><a class="hover:text-white" href="#">Privacy Policy</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold">Newsletter</h4>
          <p class="mt-3 text-sm text-slate-400">Get product updates and exclusive offers.</p>
          <form class="mt-3 flex gap-2">
            <input type="email" required placeholder="Your email" class="w-full rounded-md border-0 px-3 py-2 text-slate-800" />
            <button class="px-4 py-2 rounded-md bg-amber-600 text-white font-semibold hover:bg-amber-700">Join</button>
          </form>
          <div class="mt-4 flex items-center gap-3 text-slate-400">
            <a href="#" aria-label="facebook" class="hover:text-white">Fb</a>
            <a href="#" aria-label="instagram" class="hover:text-white">Ig</a>
            <a href="#" aria-label="twitter" class="hover:text-white">Tw</a>
            <a href="#" aria-label="youtube" class="hover:text-white">Yt</a>
          </div>
        </div>
      </div>
      <div class="mt-10 border-t border-white/10 pt-6 text-xs text-slate-400 flex items-center justify-between">
        <p>© <span id="year"></span> SSB Leather. All rights reserved.</p>
        <p>Terms · Privacy</p>
      </div>
    </div>
    <script>document.getElementById('year').textContent = new Date().getFullYear();</script>
  </footer>