/**
 * Main JavaScript for Berita Theme
 * 
 * @package Berita
 * @since 1.1.0
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        
        // ============================================
        // 1. MOBILE HAMBURGER MENU
        // ============================================
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('.nav-menu');

        if (hamburger && navMenu) {
            hamburger.addEventListener('click', function(e) {
                e.stopPropagation();
                const isExpanded = hamburger.getAttribute('aria-expanded') === 'true';
                hamburger.setAttribute('aria-expanded', !isExpanded);
                hamburger.classList.toggle('active');
                navMenu.classList.toggle('active');
            });

            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
                    hamburger.classList.remove('active');
                    navMenu.classList.remove('active');
                    hamburger.setAttribute('aria-expanded', 'false');
                }
            });
        }

        // ============================================
        // 2. SEARCH MODAL OVERLAY
        // ============================================
        const searchToggle = document.querySelector('.search-toggle');
        const searchOverlay = document.querySelector('.search-overlay');
        const searchClose = document.querySelector('.search-close');

        function openSearch(e) {
            if (e) e.preventDefault();
            if (searchOverlay) {
                searchOverlay.classList.add('active');
                document.body.classList.add('search-modal-open');
                const searchInput = searchOverlay.querySelector('input[type="search"], input[name="s"]');
                if (searchInput) {
                    setTimeout(function() {
                        searchInput.focus();
                    }, 150);
                }
            }
        }

        function closeSearch(e) {
            if (e) e.preventDefault();
            if (searchOverlay) {
                searchOverlay.classList.remove('active');
                document.body.classList.remove('search-modal-open');
            }
        }

        if (searchToggle) {
            searchToggle.addEventListener('click', openSearch);
        }

        if (searchClose) {
            searchClose.addEventListener('click', closeSearch);
        }

        if (searchOverlay) {
            searchOverlay.addEventListener('click', function(e) {
                if (e.target === searchOverlay) {
                    closeSearch();
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay && searchOverlay.classList.contains('active')) {
                closeSearch();
            }
        });

        // ============================================
        // 3. BREAKING NEWS SLIDER TICKER
        // ============================================
        const breakingSlider = document.querySelector('.breaking-news-slider');
        const breakingPrev = document.querySelector('.breaking-news-prev');
        const breakingNext = document.querySelector('.breaking-news-next');

        if (breakingSlider) {
            const slides = breakingSlider.querySelectorAll('.breaking-news-slide');
            let currentIndex = 0;
            let slideInterval = null;

            function goToSlide(index) {
                if (slides.length <= 1) return;
                slides[currentIndex].classList.remove('active');
                currentIndex = (index + slides.length) % slides.length;
                slides[currentIndex].classList.add('active');
            }

            function startAutoSlide() {
                if (slides.length > 1) {
                    slideInterval = setInterval(function() {
                        goToSlide(currentIndex + 1);
                    }, 5000);
                }
            }

            function stopAutoSlide() {
                if (slideInterval) {
                    clearInterval(slideInterval);
                }
            }

            if (breakingPrev) {
                breakingPrev.addEventListener('click', function() {
                    stopAutoSlide();
                    goToSlide(currentIndex - 1);
                    startAutoSlide();
                });
            }

            if (breakingNext) {
                breakingNext.addEventListener('click', function() {
                    stopAutoSlide();
                    goToSlide(currentIndex + 1);
                    startAutoSlide();
                });
            }

            breakingSlider.addEventListener('mouseenter', stopAutoSlide);
            breakingSlider.addEventListener('mouseleave', startAutoSlide);

            startAutoSlide();
        }

        // ============================================
        // 4. BERITA TERBARU REAL TABS
        // ============================================
        const tabButtons = document.querySelectorAll('.latest-tabs .tab-btn');
        const tabPanes = document.querySelectorAll('.latest-news-block .tab-pane');

        tabButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-tab');
                
                // Update buttons
                tabButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-selected', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');

                // Update panes
                tabPanes.forEach(function(pane) {
                    if (pane.id === targetId) {
                        pane.classList.add('active');
                    } else {
                        pane.classList.remove('active');
                    }
                });
            });
        });

        // ============================================
        // 5. SOROTAN STORY VIEWER
        // ============================================
        const sorotanDataEl = document.getElementById('berita-sorotan-data');
        const sorotanViewer = document.getElementById('sorotan-viewer');

        if (sorotanDataEl && sorotanViewer) {
            let sorotanGroups = [];
            try {
                sorotanGroups = JSON.parse(sorotanDataEl.textContent || '[]');
            } catch (e) {
                sorotanGroups = [];
            }

            const cfg = window.beritaSorotanConfig || {};
            const slideDuration = cfg.slideDuration || 5000;

            let groupIndex = 0;
            let slideIndex = 0;
            let slideTimer = null;

            const els = {
                progress: document.getElementById('sorotan-progress'),
                avatar: document.getElementById('sorotan-story-avatar'),
                group: document.getElementById('sorotan-story-group'),
                time: document.getElementById('sorotan-story-time'),
                media: document.getElementById('sorotan-story-media'),
                title: document.getElementById('sorotan-story-title'),
                excerpt: document.getElementById('sorotan-story-excerpt'),
                cta: document.getElementById('sorotan-story-cta'),
                previewRail: document.getElementById('sorotan-preview-rail'),
            };

            function clearSlideTimer() {
                if (slideTimer) {
                    clearTimeout(slideTimer);
                    slideTimer = null;
                }
            }

            function currentGroup() {
                return sorotanGroups[groupIndex] || null;
            }

            function currentSlide() {
                const group = currentGroup();
                return group && group.stories ? group.stories[slideIndex] : null;
            }

            function renderProgress() {
                const group = currentGroup();
                if (!group || !els.progress) return;

                els.progress.innerHTML = '';
                group.stories.forEach(function(_, idx) {
                    const seg = document.createElement('div');
                    seg.className = 'sorotan-progress-seg';
                    if (idx < slideIndex) {
                        seg.classList.add('is-done');
                    } else if (idx === slideIndex) {
                        seg.classList.add('is-active');
                    }
                    const fill = document.createElement('span');
                    fill.className = 'sorotan-progress-fill';
                    fill.style.setProperty('--sorotan-duration', slideDuration + 'ms');
                    seg.appendChild(fill);
                    els.progress.appendChild(seg);
                });
            }

            function renderPreviewRail() {
                if (!els.previewRail) return;
                els.previewRail.innerHTML = '';

                for (let i = 1; i <= 2; i++) {
                    const nextGroupIdx = groupIndex + i;
                    if (nextGroupIdx >= sorotanGroups.length) break;

                    const g = sorotanGroups[nextGroupIdx];
                    const story = g.stories[0];
                    if (!story) continue;

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'sorotan-preview-card' + (i === 1 ? ' is-next' : '');
                    btn.innerHTML =
                        (story.image
                            ? '<img src="' + story.image + '" alt="">'
                            : '<span class="sorotan-preview-thumb"></span>') +
                        '<div class="sorotan-preview-card-body"><strong>' + story.title + '</strong><span>' +
                        (cfg.i18n && cfg.i18n.readArticle ? cfg.i18n.readArticle : 'Baca artikel...') +
                        '</span></div>';

                    btn.addEventListener('click', function() {
                        openViewer(nextGroupIdx, 0);
                    });

                    els.previewRail.appendChild(btn);
                }
            }

            function renderSlide() {
                const group = currentGroup();
                const slide = currentSlide();
                if (!group || !slide) return;

                if (els.group) els.group.textContent = group.label;
                if (els.time) els.time.textContent = slide.timeAgo || '';
                if (els.title) els.title.textContent = slide.title || '';
                if (els.excerpt) els.excerpt.textContent = slide.excerpt || '';
                if (els.cta) {
                    els.cta.href = slide.link || '#';
                }
                if (els.media) {
                    els.media.style.backgroundImage = slide.image ? 'url("' + slide.image + '")' : 'none';
                }
                if (els.avatar) {
                    els.avatar.style.backgroundImage = group.thumb ? 'url("' + group.thumb + '")' : 'none';
                }

                renderProgress();
                renderPreviewRail();
                scheduleNextSlide();
            }

            function scheduleNextSlide() {
                clearSlideTimer();
                slideTimer = setTimeout(function() {
                    nextSlide();
                }, slideDuration);
            }

            function nextSlide() {
                const group = currentGroup();
                if (!group) return;

                if (slideIndex < group.stories.length - 1) {
                    slideIndex++;
                    renderSlide();
                    return;
                }

                if (groupIndex < sorotanGroups.length - 1) {
                    groupIndex++;
                    slideIndex = 0;
                    renderSlide();
                    return;
                }

                closeViewer();
            }

            function prevSlide() {
                if (slideIndex > 0) {
                    slideIndex--;
                    renderSlide();
                    return;
                }

                if (groupIndex > 0) {
                    groupIndex--;
                    slideIndex = sorotanGroups[groupIndex].stories.length - 1;
                    renderSlide();
                }
            }

            function openViewer(startGroup, startSlide) {
                if (!sorotanGroups.length) return;

                groupIndex = startGroup;
                slideIndex = startSlide;
                sorotanViewer.hidden = false;
                sorotanViewer.setAttribute('aria-hidden', 'false');
                document.body.classList.add('sorotan-open');
                renderSlide();
            }

            function closeViewer() {
                clearSlideTimer();
                sorotanViewer.hidden = true;
                sorotanViewer.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('sorotan-open');
            }

            document.querySelectorAll('.sorotan-item[data-sorotan-group]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    openViewer(parseInt(this.getAttribute('data-sorotan-group'), 10) || 0, 0);
                });
            });

            sorotanViewer.querySelectorAll('[data-sorotan-close]').forEach(function(el) {
                el.addEventListener('click', closeViewer);
            });

            const navPrev = sorotanViewer.querySelector('.sorotan-nav-prev');
            const navNext = sorotanViewer.querySelector('.sorotan-nav-next');
            const tapPrev = sorotanViewer.querySelector('.sorotan-story-tap-prev');
            const tapNext = sorotanViewer.querySelector('.sorotan-story-tap-next');

            if (navPrev) {
                navPrev.addEventListener('click', function() {
                    if (groupIndex > 0) {
                        groupIndex--;
                        slideIndex = 0;
                        renderSlide();
                    }
                });
            }

            if (navNext) {
                navNext.addEventListener('click', function() {
                    if (groupIndex < sorotanGroups.length - 1) {
                        groupIndex++;
                        slideIndex = 0;
                        renderSlide();
                    } else {
                        closeViewer();
                    }
                });
            }

            if (tapPrev) tapPrev.addEventListener('click', prevSlide);
            if (tapNext) tapNext.addEventListener('click', nextSlide);

            document.addEventListener('keydown', function(e) {
                if (sorotanViewer.hidden) return;
                if (e.key === 'Escape') closeViewer();
                if (e.key === 'ArrowRight') nextSlide();
                if (e.key === 'ArrowLeft') prevSlide();
            });
        }

        // ============================================
        // 6. HOMEPAGE VIDEO PLAY BUTTON
        // ============================================
        const videoTriggers = document.querySelectorAll('.berita-video-trigger');

        videoTriggers.forEach(function(trigger) {
            trigger.addEventListener('click', function() {
                const featured = this.closest('.main-video-featured');
                if (!featured || featured.classList.contains('is-playing')) {
                    return;
                }

                const playerWrap = featured.querySelector('.main-video-player');
                const youtubeId = featured.getAttribute('data-youtube-id');
                const videoUrl = featured.getAttribute('data-video-url');

                if (!playerWrap || !videoUrl) {
                    return;
                }

                let embedHtml = '';

                if (youtubeId) {
                    embedHtml = '<div class="berita-video-embed homepage-video-embed"><iframe src="https://www.youtube.com/embed/' + youtubeId + '?rel=0&autoplay=1" title="Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div>';
                } else if (/\.(mp4|webm|ogg)(\?|$)/i.test(videoUrl)) {
                    embedHtml = '<div class="berita-video-embed homepage-video-embed"><video controls autoplay preload="metadata" src="' + videoUrl + '"></video></div>';
                }

                if (!embedHtml) {
                    window.location.href = featured.querySelector('a') ? featured.querySelector('a').href : '#';
                    return;
                }

                playerWrap.innerHTML = embedHtml;
                playerWrap.setAttribute('aria-hidden', 'false');
                featured.classList.add('is-playing');
            });
        });

    });
})();
