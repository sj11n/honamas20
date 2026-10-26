(function () {
	'use strict';
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var $ = function (s, r) { return (r || document).querySelector(s); };
	var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

	/* entrances: the parts of every section rise in, staggered, once */
	var items = $$('[data-r]');
	if ('IntersectionObserver' in window && !reduce) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
			});
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
		items.forEach(function (el) { io.observe(el); });
	} else {
		items.forEach(function (el) { el.classList.add('in'); });
	}

	/* the live thing: the name falls apart into its words */
	var syl = $$('.syl');
	var lines = $$('.syl-read li');
	function pick(i) {
		syl.forEach(function (b, n) { b.setAttribute('aria-pressed', n === i ? 'true' : 'false'); });
		lines.forEach(function (li, n) { li.hidden = n !== i; });
	}
	syl.forEach(function (b, i) {
		b.addEventListener('click', function () { pick(i); });
		b.addEventListener('mouseenter', function () { if (window.matchMedia('(hover: hover)').matches) pick(i); });
		b.addEventListener('focus', function () { pick(i); });
	});
	if (syl.length) pick(0);

	/* story accordion */
	var stages = $$('#acc .stage');
	stages.forEach(function (st) {
		$('.stage-btn', st).addEventListener('click', function () {
			stages.forEach(function (s) {
				var on = s === st;
				s.classList.toggle('is-open', on);
				$('.stage-btn', s).setAttribute('aria-expanded', on ? 'true' : 'false');
			});
		});
	});

	/* scroll-linked wordmarks: the hero name settles back, the footer name rises in */
	var heroName = $('#heroName');
	var footWord = $('#footWord');
	var ticking = false;
	function frame() {
		ticking = false;
		var vh = window.innerHeight;
		items.forEach(function (el) {
			if (!el.classList.contains('in') && el.getBoundingClientRect().top < vh * 0.92) el.classList.add('in');
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

	/* one moving picture: the film loop plays only while visible */
	var vid = $('#loop');
	if (vid && !reduce && 'IntersectionObserver' in window) {
		new IntersectionObserver(function (es) {
			es.forEach(function (e) {
				if (e.isIntersecting) { var p = vid.play(); if (p && p.catch) p.catch(function () {}); } else { vid.pause(); }
			});
		}, { threshold: 0.3 }).observe(vid);
	}

	/* hero film: still poster for reduced motion and data saver, paused when off screen */
	var hv = $('#heroVideo');
	if (hv) {
		var conn = navigator.connection || {};
		if (reduce || conn.saveData) {
			hv.removeAttribute('autoplay');
			hv.pause();
		} else if ('IntersectionObserver' in window) {
			new IntersectionObserver(function (es) {
				es.forEach(function (e) {
					if (e.isIntersecting) { var q = hv.play(); if (q && q.catch) q.catch(function () {}); } else { hv.pause(); }
				});
			}, { threshold: 0.05 }).observe(hv);
		}
	}

	/* phone menu closes after a choice */
	var menu = $('.menu');
	if (menu) $$('a', menu).forEach(function (a) { a.addEventListener('click', function () { menu.open = false; }); });
})();
