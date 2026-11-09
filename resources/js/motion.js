import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

gsap.registerPlugin(ScrollTrigger);

const root = document.documentElement;
const EASE = 'expo.out';

/**
 * Wraps every word of an element in a mask so it can slide up from below.
 * Nested elements (e.g. the gradient span) are preserved.
 */
function splitWords(element) {
    const walk = (node) => {
        [...node.childNodes].forEach((child) => {
            if (child.nodeType === Node.ELEMENT_NODE) {
                walk(child);

                return;
            }

            if (child.nodeType !== Node.TEXT_NODE || !child.textContent.trim()) {
                return;
            }

            const fragment = document.createDocumentFragment();

            child.textContent.split(/(\s+)/).forEach((part) => {
                if (!part) {
                    return;
                }

                if (/^\s+$/.test(part)) {
                    fragment.append(' ');

                    return;
                }

                const mask = document.createElement('span');
                const word = document.createElement('span');
                mask.className = 'split-mask';
                word.className = 'split-word';
                word.textContent = part;
                mask.append(word);
                fragment.append(mask);
            });

            child.replaceWith(fragment);
        });
    };

    walk(element);

    return element.querySelectorAll('.split-word');
}

function initSmoothScroll() {
    const lenis = new Lenis({ lerp: 0.1, wheelMultiplier: 1 });

    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => lenis.raf(time * 1000));
    gsap.ticker.lagSmoothing(0);

    return lenis;
}

/** Same-page anchor links glide instead of jumping. */
function initAnchors(lenis) {
    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href*="#"]');

        if (!link) {
            return;
        }

        const url = new URL(link.href, window.location.href);

        if (url.pathname !== window.location.pathname || !url.hash) {
            return;
        }

        const target = document.querySelector(url.hash);

        if (!target) {
            return;
        }

        event.preventDefault();
        document.dispatchEvent(new CustomEvent('menu:close'));

        if (lenis) {
            lenis.scrollTo(target, { offset: url.hash === '#directions' ? 0 : -64, duration: 1.4 });
        } else {
            target.scrollIntoView();
        }

        history.replaceState(null, '', url.hash);
    });
}

/** Header turns glassy after the hero and hides while scrolling down. */
function initHeader() {
    const header = document.querySelector('[data-header]');

    if (!header) {
        return;
    }

    ScrollTrigger.create({
        start: 'top -40',
        end: 'max',
        onUpdate: (self) => {
            header.toggleAttribute('data-scrolled', self.scroll() > 40);
            const menuOpen = root.hasAttribute('data-menu-open');
            header.toggleAttribute('data-hidden', !menuOpen && self.direction === 1 && self.scroll() > 600);
        },
        onLeaveBack: () => {
            header.removeAttribute('data-scrolled');
            header.removeAttribute('data-hidden');
        },
    });
}

function initMobileMenu(lenis, animate) {
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (!toggle || !menu) {
        return;
    }

    const items = menu.querySelectorAll('[data-menu-item]');

    const setOpen = (open) => {
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? toggle.dataset.labelClose : toggle.dataset.labelOpen);
        root.toggleAttribute('data-menu-open', open);
        menu.hidden = !open;
        document.querySelector('[data-header]')?.removeAttribute('data-hidden');

        if (open) {
            lenis?.stop();
            document.body.style.overflow = 'hidden';

            if (animate) {
                gsap.fromTo(menu, { opacity: 0 }, { opacity: 1, duration: 0.4, ease: 'power2.out' });
                gsap.fromTo(items, { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, ease: EASE, stagger: 0.05 });
            }
        } else {
            lenis?.start();
            document.body.style.overflow = '';
        }
    };

    toggle.addEventListener('click', () => setOpen(toggle.getAttribute('aria-expanded') !== 'true'));
    document.addEventListener('menu:close', () => setOpen(false));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !menu.hidden) {
            setOpen(false);
            toggle.focus();
        }
    });
    window.matchMedia('(min-width: 64rem)').addEventListener('change', (event) => event.matches && setOpen(false));
}

/** The phone screen follows whichever step is in the middle of the viewport. */
function initAppSteps() {
    const steps = document.querySelectorAll('[data-app-step]');
    const screens = document.querySelectorAll('[data-phone-screen]');
    const tabs = document.querySelectorAll('[data-phone-tab]');

    const activate = (index) => {
        steps.forEach((step) => step.toggleAttribute('data-active', step.dataset.appStep === String(index)));
        screens.forEach((screen) => {
            const active = screen.dataset.phoneScreen === String(index);
            screen.toggleAttribute('data-active', active);
            screen.setAttribute('aria-hidden', String(!active));
        });
        tabs.forEach((tab) => tab.toggleAttribute('data-active', tab.dataset.phoneTab === String(index)));
    };

    steps.forEach((step) => {
        ScrollTrigger.create({
            trigger: step,
            start: 'top 55%',
            end: 'bottom 55%',
            onToggle: (self) => self.isActive && activate(step.dataset.appStep),
        });
    });
}

function initPillars() {
    document.querySelectorAll('[data-pillar]').forEach((pillar) => {
        ScrollTrigger.create({
            trigger: pillar,
            start: 'top 72%',
            onEnter: () => pillar.setAttribute('data-active', ''),
            onLeaveBack: () => pillar.removeAttribute('data-active'),
        });
    });
}

/** Headline lines are painted like a road sign: a coloured block sweeps in, then uncovers the text. */
function initHero() {
    const intro = gsap.timeline({ defaults: { ease: 'power4.inOut' } });

    document.querySelectorAll('[data-wipe-line]').forEach((line, index) => {
        const text = line.firstElementChild;
        const block = document.createElement('span');
        block.className = 'wipe-block';
        block.style.background = line.dataset.wipeColor;
        line.append(block);

        const at = 0.25 + index * 0.3;
        intro
            .to(block, { scaleX: 1, duration: 0.55 }, at)
            .set(text, { visibility: 'visible' }, at + 0.55)
            .set(block, { transformOrigin: 'right center' }, at + 0.55)
            .to(block, { scaleX: 0, duration: 0.6 }, at + 0.55);
    });

    intro
        .fromTo('[data-hero-fade]', { opacity: 0, y: 24 }, { opacity: 1, y: 0, duration: 1.1, ease: EASE, stagger: 0.1 }, 0.9)
        .from('[data-hero-car]', { yPercent: 320, duration: 1.8, ease: 'power3.out' }, 0);

    // Scrolling down = accelerating: the car pulls away up the road while the text lifts off.
    gsap.to('[data-hero-car]', {
        y: () => -window.innerHeight * 0.75,
        ease: 'power2.in',
        scrollTrigger: { trigger: '[data-hero]', start: 'top top', end: 'bottom top', scrub: true, invalidateOnRefresh: true },
    });

    gsap.to('[data-hero-content]', {
        yPercent: -12,
        opacity: 0,
        ease: 'none',
        scrollTrigger: { trigger: '[data-hero]', start: 'top top', end: 'bottom 15%', scrub: true },
    });
}

/** Lane dashes run under the car; scroll velocity adds speed on top of a cruising pace. */
function initRoad(lenis) {
    const road = document.querySelector('[data-road]');

    if (!road) {
        return;
    }

    const DASH_PERIOD = 104; // 6.5rem: one dash + one gap
    let offset = 0;
    let visible = true;

    ScrollTrigger.create({
        trigger: '[data-hero]',
        start: 'top bottom',
        end: 'bottom top',
        onToggle: (self) => (visible = self.isActive),
    });

    gsap.ticker.add(() => {
        if (!visible) {
            return;
        }

        offset = (offset + 3.2 + Math.min(40, Math.abs(lenis?.velocity ?? 0)) * 1.1) % DASH_PERIOD;
        road.style.setProperty('--road-y', `${offset}px`);
    });
}

/** Dashboard cluster: 1 px scrolled = 1 m driven; scroll velocity drives the speed readout. */
function initOdometer(lenis) {
    const cluster = document.querySelector('[data-odometer]');

    if (!cluster) {
        return;
    }

    const strips = [...cluster.querySelectorAll('[data-odo-digit]')];
    const speedReadout = cluster.querySelector('[data-speed]');
    const CELL = 1.6; // rem
    let speed = 0;
    let shownSpeed = -1;
    let lastScroll = -1;

    gsap.ticker.add(() => {
        const scroll = window.scrollY;

        if (scroll !== lastScroll) {
            lastScroll = scroll;
            const tenths = scroll / 100;
            const whole = Math.floor(tenths);
            [Math.floor(whole / 1000) % 10, Math.floor(whole / 100) % 10, Math.floor(whole / 10) % 10].forEach((digit, index) => {
                strips[index].style.transform = `translateY(${-digit * CELL}rem)`;
            });
            strips[3].style.transform = `translateY(${-(tenths % 10) * CELL}rem)`;
        }

        const target = Math.min(180, Math.abs(lenis?.velocity ?? 0) * 7);
        speed += (target - speed) * 0.08;
        const rounded = Math.round(speed);

        if (rounded !== shownSpeed) {
            shownSpeed = rounded;
            speedReadout.textContent = String(rounded);
        }
    });
}
function initReveals() {
    document.querySelectorAll('[data-split]:not([data-hero-title])').forEach((element) => {
        const words = splitWords(element);
        gsap.set(element, { visibility: 'visible' });
        gsap.from(words, {
            yPercent: 115,
            duration: 1.2,
            ease: EASE,
            stagger: 0.04,
            scrollTrigger: { trigger: element, start: 'top 88%', once: true },
        });
    });

    document.querySelectorAll('[data-reveal]').forEach((element) => {
        gsap.fromTo(
            element,
            { opacity: 0, y: 40 },
            {
                opacity: 1,
                y: 0,
                duration: 1.3,
                ease: EASE,
                scrollTrigger: { trigger: element, start: 'top 90%', once: true },
            },
        );
    });

    document.querySelectorAll('[data-reveal-stagger]').forEach((group) => {
        gsap.fromTo(
            group.children,
            { opacity: 0, y: 60 },
            {
                opacity: 1,
                y: 0,
                duration: 1.3,
                ease: EASE,
                stagger: 0.1,
                scrollTrigger: { trigger: group, start: 'top 85%', once: true },
            },
        );
    });
}

function initCounters() {
    const locale = root.lang || 'fr';
    const format = new Intl.NumberFormat(locale);

    document.querySelectorAll('[data-count]').forEach((element) => {
        const target = Number(element.dataset.count);
        const counter = { value: 0 };

        gsap.to(counter, {
            value: target,
            duration: target > 100 ? 1.8 : 1.2,
            ease: 'power3.out',
            scrollTrigger: { trigger: element, start: 'top 88%', once: true },
            onUpdate: () => {
                element.textContent = format.format(Math.round(counter.value));
            },
        });
    });

    document.querySelectorAll('[data-strike]').forEach((line) => {
        gsap.from(line, {
            scaleX: 0,
            duration: 0.9,
            delay: 0.9,
            ease: 'power3.inOut',
            scrollTrigger: { trigger: line, start: 'top 90%', once: true },
        });
    });
}

/** Ambition statement: each word goes from dim to bright as you scroll through it. */
function initWordsScrub() {
    document.querySelectorAll('[data-words-scrub]').forEach((element) => {
        const words = splitWords(element);

        gsap.fromTo(
            words,
            { opacity: 0.12 },
            {
                opacity: 1,
                ease: 'none',
                stagger: 0.1,
                scrollTrigger: { trigger: element, start: 'top 80%', end: 'bottom 45%', scrub: true },
            },
        );
    });
}

function initCtaBand() {
    const band = document.querySelector('[data-cta-band]');

    if (!band) {
        return;
    }

    gsap.fromTo(
        band,
        { clipPath: 'inset(12% 8% 12% 8% round 6px)' },
        {
            clipPath: 'inset(0% 0% 0% 0% round 6px)',
            ease: 'none',
            scrollTrigger: { trigger: band, start: 'top 95%', end: 'top 35%', scrub: true },
        },
    );
}

function initResponsiveScenes() {
    const media = gsap.matchMedia();

    // Desktop: the directions section pins and we drive past seven exit signs.
    media.add('(min-width: 64rem)', () => {
        const section = document.querySelector('[data-directions]');
        const track = section?.querySelector('[data-directions-track]');
        const road = section?.querySelector('[data-directions-road]');
        const current = section?.querySelector('[data-directions-current]');
        const signs = section ? [...section.querySelectorAll('[data-direction-sign]')] : [];

        if (section && track) {
            const distance = () => Math.max(0, track.scrollWidth - window.innerWidth);

            const drive = gsap.to(track, {
                x: () => -distance(),
                ease: 'none',
                scrollTrigger: {
                    trigger: section,
                    start: 'top top',
                    end: () => `+=${distance()}`,
                    pin: true,
                    scrub: 0.8,
                    invalidateOnRefresh: true,
                    onUpdate: (self) => {
                        const index = Math.min(signs.length - 1, Math.floor(self.progress * signs.length));
                        current.textContent = String(index + 1).padStart(2, '0');
                        // The road is closer than the signs, so it passes faster (parallax).
                        road?.style.setProperty('--road-x', `${-self.progress * distance() * 1.8}px`);
                    },
                },
            });

            // Each sign grows as we approach it, like on a real motorway.
            signs.forEach((sign) => {
                gsap.fromTo(
                    sign,
                    { scale: 0.84, opacity: 0.45, transformOrigin: 'center bottom' },
                    {
                        scale: 1,
                        opacity: 1,
                        ease: 'none',
                        scrollTrigger: { trigger: sign, containerAnimation: drive, start: 'left right', end: 'center 60%', scrub: true },
                    },
                );
            });
        }

        const phone = document.querySelector('[data-phone-body]');

        if (phone) {
            gsap.fromTo(
                phone,
                { rotateY: -22, rotateX: 8, y: 80 },
                {
                    rotateY: 14,
                    rotateX: -4,
                    y: -40,
                    ease: 'none',
                    scrollTrigger: { trigger: '[data-app]', start: 'top 85%', end: 'bottom 30%', scrub: true },
                },
            );
        }
    });

    media.add('(hover: hover) and (pointer: fine)', () => {
        const cleanups = [...document.querySelectorAll('[data-tilt]')].map((card) => {
            const rotateX = gsap.quickTo(card, 'rotateX', { duration: 0.6, ease: 'power3.out' });
            const rotateY = gsap.quickTo(card, 'rotateY', { duration: 0.6, ease: 'power3.out' });

            const onMove = (event) => {
                const bounds = card.getBoundingClientRect();
                const x = (event.clientX - bounds.left) / bounds.width - 0.5;
                const y = (event.clientY - bounds.top) / bounds.height - 0.5;
                rotateY(x * 10);
                rotateX(y * -10);
            };

            const onLeave = () => {
                rotateX(0);
                rotateY(0);
            };

            card.addEventListener('pointermove', onMove);
            card.addEventListener('pointerleave', onLeave);

            return () => {
                card.removeEventListener('pointermove', onMove);
                card.removeEventListener('pointerleave', onLeave);
            };
        });

        return () => cleanups.forEach((cleanup) => cleanup());
    });
}

function initContactForm() {
    const form = document.querySelector('[data-contact-form]');

    form?.addEventListener('submit', () => {
        const button = form.querySelector('[type="submit"]');
        button.disabled = true;
        button.classList.add('opacity-70');
        button.firstChild.textContent = `${button.dataset.sendingLabel} `;
    });
}

export function boot() {
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const lenis = reducedMotion ? null : initSmoothScroll();

    initAnchors(lenis);
    initMobileMenu(lenis, !reducedMotion);
    initContactForm();

    // Pinned scenes first: every trigger created after them accounts for the pin spacing.
    if (!reducedMotion) {
        initResponsiveScenes();
    }

    initHeader();
    initAppSteps();
    initPillars();

    if (!reducedMotion) {
        initHero();
        initRoad(lenis);
        initOdometer(lenis);
        initReveals();
        initCounters();
        initWordsScrub();
        initCtaBand();
    }

    root.classList.add('motion-ready');

    // Fonts change line lengths: recompute every trigger once they are in.
    document.fonts?.ready.then(() => ScrollTrigger.refresh());

    // Arriving on /#contact (e.g. after the form redirect): jump there once layout is final.
    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);

        if (target) {
            requestAnimationFrame(() => {
                ScrollTrigger.refresh();
                lenis ? lenis.scrollTo(target, { immediate: true, offset: -64 }) : target.scrollIntoView();
            });
        }
    }
}
