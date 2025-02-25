📌 WordPress Caching Plugin

⚡ Supercharge your WordPress site with fast and efficient page caching!

This plugin stores generated HTML as files, reducing database queries and improving load times.
Built with Vue.js for an easy-to-use WP-Admin interface! 🎨

✨ Features

✅ File-based caching – Speeds up page load times!
✅ Vue-powered admin panel – Clear cache with a single click. 🖱️
✅ WordPress REST API integration – Manage cache via API requests. 🔗
✅ Automatic caching – Caches pages for logged-out users. 🚀
✅ Supports custom permalinks – Works with /post-name/.

🛠️ Installation & Usage

1️⃣ Download & Install
	•	Upload the plugin to wp-content/plugins/
	•	Activate it in WordPress Admin > Plugins

2️⃣ Check Cache Status
	•	Go to WP-Admin > WP Cache
	•	See how many pages are cached.

3️⃣ Clear Cache
	•	Click “Clear Cache” in the admin panel.
	•	Or, send a POST request to:

/wp-json/wp-cache/v1/clear

🔮 Future Work

💡 Redis/Memcached support – Store cache in memory for even faster performance.
💡 Cache expiration settings – Let users control cache duration.
💡 Per-page caching – Clear individual pages instead of all at once.
💡 Preloading cache – Automatically cache important pages in advance.

📜 License

🔓 Open-source! Modify, share, and improve! 🎉

🚀 Enjoy a faster WordPress experience! Let us know what you’d like next!! 🔥