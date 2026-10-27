(function () {
	'use strict';
	window.honamasReady = true;
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var $ = function (s, r) { return (r || document).querySelector(s); };
	var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

	/* the live thing: the name falls apart into its words. Built from the list block under „Silben“. */
	$$('.syllables').forEach(function (box) {
		var list = $('.syl-list', box);
		if (!list) return;
		var items = $$('li', list);
		var row = document.createElement('div');
		row.className = 'syl-row';
		row.setAttribute('role', 'group');
		row.setAttribute('aria-label', 'Der Name in Silben');
		var buttons = items.map(function (li, i) {
			var strong = $('strong', li);
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'syl mono-type';
			b.textContent = strong ? strong.textContent : String(i + 1);
			row.appendChild(b);
			return b;
		});
		list.setAttribute('aria-live', 'polite');
		function pick(i) {
			buttons.forEach(function (b, n) { b.setAttribute('aria-pressed', n === i ? 'true' : 'false'); });
			items.forEach(function (li, n) { li.hidden = n !== i; });
		}
		buttons.forEach(function (b, i) {
			b.addEventListener('click', function () { pick(i); });
			b.addEventListener('focus', function () { pick(i); });
			b.addEventListener('mouseenter', function () { if (window.matchMedia('(hover: hover)').matches) pick(i); });
		});
		box.insertBefore(row, box.firstChild);
		if (buttons.length) pick(0);
	});

	/* story accordion, built from the chapter groups: heading, text, link and picture each */
	$$('.acc').forEach(function (acc) {
		var stages = $$('.stage', acc);
		stages.forEach(function (st, i) {
			var heading = $('h3', st);
			var figure = $('figure', st);
			var label = heading ? heading.textContent.split(':')[0].trim() : String(i + 1);
			var btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'stage-btn';
			btn.innerHTML = '<span class="rot"></span>';
			btn.firstChild.textContent = label;
			var panel = document.createElement('div');
			panel.className = 'stage-panel';
			var text = document.createElement('div');
			text.className = 'stage-text';
			var body = document.createElement('div');
			body.className = 'stage-body';
			$$(':scope > p', st).forEach(function (p) { body.appendChild(p); });
			if (heading) text.appendChild(heading);
			text.appendChild(body);
			panel.appendChild(text);
			var media = document.createElement('div');
			media.className = 'stage-media';
			if (figure) media.appendChild(figure);
			panel.appendChild(media);
			st.appendChild(btn);
			st.appendChild(panel);
			btn.setAttribute('aria-expanded', i === 0 ? 'true' : 'false');
			if (i === 0) st.classList.add('is-open');
			btn.addEventListener('click', function () {
				stages.forEach(function (s) {
					var on = s === st;
					s.classList.toggle('is-open', on);
					$('.stage-btn', s).setAttribute('aria-expanded', on ? 'true' : 'false');
				});
			});
		});
		acc.classList.add('is-ready');
	});

	/* side navigation lists: mark the page you are on */
	$$('ul.chap-nav a').forEach(function (a) {
		if (a.pathname.replace(/\/$/, '') === location.pathname.replace(/\/$/, '')) a.setAttribute('aria-current', 'page');
	});

	/* entrances: the parts of every section rise in, staggered by their place among their siblings */
	var items = $$('[data-r]');
	items.forEach(function (el) {
		var n = 0, s = el.previousElementSibling;
		while (s && n < 4) { if (s.hasAttribute('data-r')) n++; s = s.previousElementSibling; }
		el.style.setProperty('--d', n);
	});
	$$('.bar, .roster-item, .source, .pager-link, .bar-link, ul.chap-nav li, .teaser-list li, .honamas-archive-card').forEach(function (el, i) {
		el.setAttribute('data-r', '');
		el.style.setProperty('--d', i % 4);
		items.push(el);
	});
	function reveal(el) { el.classList.add('in'); }
	if ('IntersectionObserver' in window && !reduce) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) { reveal(e.target); io.unobserve(e.target); }
			});
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 });
		items.forEach(function (el) { io.observe(el); });
	} else {
		items.forEach(reveal);
	}

	/* scroll-linked wordmarks: the hero name settles back, the footer name rises in */
	var heroName = $('.hero-name');
	var footWord = $('.foot-word');
	var ticking = false;
	function frame() {
		ticking = false;
		var vh = window.innerHeight;
		items.forEach(function (el) {
			if (!el.classList.contains('in') && el.getBoundingClientRect().top < vh * 0.92) reveal(el);
		});
		if (heroName) {
			var p = Math.min(Math.max(window.scrollY / vh, 0), 1);
			heroName.style.transform = 'scale(' + (1 - 0.06 * p).toFixed(4) + ')';
		}
		if (footWord) {
			var r = footWord.getBoundingClientRect();
			var q = Math.min(Math.max((vh - r.top) / vh, 0), 1);
			footWord.style.transform = 'scale(' + (0.94 + 0.06 * q).toFixed(4) + ')';
		}
	}
	if (!reduce) {
		window.addEventListener('scroll', function () {
			if (!ticking) { ticking = true; requestAnimationFrame(frame); }
		}, { passive: true });
		window.addEventListener('resize', frame);
		frame();
	}

	/* videos: muted loops play while on screen; still poster for reduced motion and data saver */
	var saveData = navigator.connection && navigator.connection.saveData;
	$$('video[autoplay], .film-media video, .prose video, .chap-lead video').forEach(function (v) {
		v.muted = true;
		v.setAttribute('playsinline', '');
		if (reduce || saveData) {
			v.removeAttribute('autoplay');
			v.pause();
			return;
		}
		v.loop = true;
		if ('IntersectionObserver' in window) {
			new IntersectionObserver(function (es) {
				es.forEach(function (e) {
					if (e.isIntersecting) { var pr = v.play(); if (pr && pr.catch) pr.catch(function () {}); } else { v.pause(); }
				});
			}, { threshold: 0.05 }).observe(v);
		}
	});
})();
