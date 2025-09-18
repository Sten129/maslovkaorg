document.addEventListener('DOMContentLoaded', () => {
	const homePage = document.querySelector('.home'); // для работы на главной и многих проверок в коде.
	// cookies
	const cookiesBanner = document.getElementById('cookiesBanner');
	const acceptCookiesBtn = document.getElementById('acceptCookies');

	// check cookies
	if (!getCookie('cookiesAccepted')) {
		cookiesBanner.style.display = 'block';
	} else {
		cookiesBanner.style.display = 'none';
	}

	acceptCookiesBtn.addEventListener('click', function () {
		setCookie('cookiesAccepted', 'true', 30); //30 days
		cookiesBanner.style.display = 'none';
	});

	function setCookie(name, value, days) {
		const date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		const expires = "expires=" + date.toUTCString();
		document.cookie = name + "=" + value + ";" + expires + ";path=/";
	}
	function getCookie(name) {
		const nameEQ = name + "=";
		const ca = document.cookie.split(';');
		for (let i = 0; i < ca.length; i++) {
			let c = ca[i];
			while (c.charAt(0) === ' ') c = c.substring(1);
			if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length);
		}
		return null;
	}

	//Menu
	const menuBlock = document.querySelector('.menu');
	const burger = document.querySelector('.menu_mobile');

	if (menuBlock && burger) {
		const newsElement = document.querySelector('#news');
		// if (!page){
		// 	if (!newsElement) return;
		// }

		const menuMainLink = menuBlock.firstElementChild;
					
		if(homePage){
			menuMainLink.setAttribute('href', '#news');
		}
		
		const swapLink = menuMainLink;
		burger.addEventListener('click', () => {
			if (!burger.classList.contains("active")) {
				menuBlock.classList.add('active');
				burger.classList.add('active');
			} else {
				menuBlock.classList.add('inactive');
				burger.classList.remove('active');
				setTimeout(() => {
					menuBlock.classList.remove('active');
					menuBlock.classList.remove('inactive');
				}, 400);
			}
		});

		let menuTop = 0;
		let burgerTop = 0;
		let newsBlockTop = 0;

		function updatePositions() {
			const menuHadFixed = menuBlock.classList.contains('fixed');
			if (menuHadFixed) menuBlock.classList.remove('fixed');

			menuTop = menuBlock.offsetTop;
			burgerTop = burger.offsetTop;
			if (newsElement) {
				newsBlockTop = newsElement.offsetTop;
			}

			if (menuHadFixed) menuBlock.classList.add('fixed');
		}

		// --- Scroll --- (ссылки)
		const isHomepage = document.body.classList.contains('home');

		function removeMainLink() {
			if (isHomepage) {
				menuMainLink.classList.add('selected');
				swapLink.setAttribute('href', "/");
			}
		}

		function addMainLink() {
			if (isHomepage) {
				menuMainLink.classList.remove('selected');
				swapLink.setAttribute('href', "#news");
			}
		}

		function handleScroll() {
			const scrollY = window.scrollY;
			if (scrollY >= burgerTop) {
				burger.classList.add('fixed');
				if (scrollY >= newsBlockTop) {
					removeMainLink();
				}
			} else {
				burger.classList.remove('fixed');
				if (scrollY <= newsBlockTop) {
					addMainLink();
				}
			}
			if (scrollY >= menuTop) {
				if (window.innerWidth >= 768) {
					menuBlock.classList.add('fixed');
					removeMainLink();
				}
			} else {
				menuBlock.classList.remove('fixed');
				addMainLink();
			}
		}
		// requestAnimationFrame (для плавности)
		let ticking = false;
		window.addEventListener('scroll', () => {
			if (!ticking) {
				window.requestAnimationFrame(() => {
					handleScroll();
					ticking = false;
				});
				ticking = true;
			}
		});

		window.addEventListener('resize', () => {
			updatePositions();
			handleScroll();
		});

		updatePositions();
		handleScroll();

		window.addEventListener('load', () => {
			updatePositions();
			handleScroll();
		});
	}

	// зоны 
	if(homePage){
		const zones = document.querySelectorAll('.zone');
		let mobileInterval = null;
		let currentIndex = 0;
		if(zones){
			zones.forEach((zone, index) => {
				zone.addEventListener('mouseenter', () => {
					if (window.innerWidth < 768) return;
					const { left, right } = zonesConfig[index];
					changeImage('left', left);
					changeImage('right', right);
				});
			});

			function changeImage(side, newSrc) {
				const half = document.querySelector(`.half.${side}`);
				const oldImg = half.querySelector('.image.old');
				const newImg = half.querySelector('.image.new');

				if (newImg.src.endsWith(newSrc)) return;

				newImg.src = newSrc;
				newImg.style.opacity = 1;

				setTimeout(() => {
					oldImg.src = newSrc;
					newImg.style.opacity = 0;
				}, 0);
			}

			//для мобильной версии
			function startMobileRotation() {
				if (mobileInterval) return;

				mobileInterval = setInterval(() => {
					const { left, right } = zonesConfig[currentIndex];
					changeImage('left', left);
					changeImage('right', right);

					currentIndex = (currentIndex + 1) % zonesConfig.length;
				}, 1000);
			}

			function stopMobileRotation() {
				clearInterval(mobileInterval);
				mobileInterval = null;
			}

			function handleResize() {
				if (window.innerWidth < 768) {
					startMobileRotation();
				} else {
					stopMobileRotation();
				}
			}

			handleResize();
			window.addEventListener('resize', handleResize);
		}
	}


	

	// news spoiler
	const newsItem = document.querySelectorAll('.news_item');

	if (newsItem[0]) {
		newsItem.forEach((spoiler, id) => {
			const newsBlock = spoiler.querySelector('.news_item_block');
			let spoilerSize = spoiler.querySelector('.news_item_blank').offsetHeight;

			if (newsBlock) {
				if (id === 0) {
					newsBlock.style.marginTop = `-${spoilerSize}px`;
				}
				window.addEventListener('resize', () => {
					spoilerSize = spoiler.querySelector('.news_item_blank').offsetHeight;
					newsBlock.style.marginTop = `-${spoilerSize}px`;
					if (id === 0) {
						newsBlock.style.marginTop = `-${spoilerSize}px`;
					}
				})

				spoiler.addEventListener('click', (e) => {
					if (e.target.closest('.no-action')) return;

					if (!spoiler.classList.contains('active')) {
						spoiler.classList.add('active');
						newsBlock.classList.add('active');
						newsBlock.style.marginTop = `-${spoilerSize}px`;

					} else {
						closeSpoiler();
					}
				});

				const spoilerImg = spoiler.querySelector('.news__block-img');
				spoilerImg.addEventListener('click', closeSpoiler);
			}

			function closeSpoiler() {
				newsBlock.classList.add('inactive');
				spoiler.classList.add('inactive');
				spoiler.classList.remove('active', 'inactive');
				newsBlock.classList.remove('active', 'inactive');
			}
		});
	}
	// change text - news_subscribe_txt
	const newsSubscribe = document.querySelector('.news_subscribe_txt');
	if(newsSubscribe){

		newsSubscribe.innerHTML = "Подписаться на события";

		function checkWindowSize() {
			if (window.matchMedia("(max-width: 768px)").matches) {
				newsSubscribe.innerHTML = "Подписаться на события";
			} else {
				newsSubscribe.innerHTML = "Подписаться";
			}
		}
		checkWindowSize();
		window.addEventListener('resize', checkWindowSize);
	}
	// slider cards
	const cardsList = document.querySelector('.cards_list');
	const isMobile = window.matchMedia('(max-width: 1220px)').matches;
	const isMobileDisable = window.matchMedia('(max-width: 480px)').matches;
	if (cardsList && isMobile && !isMobileDisable) {
		let isDown = false;
		let startX;
		let scrollLeft;

		const cardsItems = cardsList.querySelectorAll('.cards_item, .cards_item *');
		cardsItems.forEach(item => {
			item.addEventListener('dragstart', (e) => {
				e.preventDefault();
				e.stopPropagation();
				return false;
			});
		});

		cardsList.addEventListener('mousedown', (e) => {
			isDown = true;
			cardsList.classList.add('dragging');
			startX = e.pageX - cardsList.offsetLeft;
			scrollLeft = cardsList.scrollLeft;
		});

		cardsList.addEventListener('mouseleave', () => {
			isDown = false;
			cardsList.classList.remove('dragging');
		});

		cardsList.addEventListener('mouseup', () => {
			isDown = false;
			cardsList.classList.remove('dragging');
		});

		cardsList.addEventListener('mousemove', (e) => {
			if (!isDown) return;
			e.preventDefault();
			const x = e.pageX - cardsList.offsetLeft;
			const walk = (x - startX) * 1; // speed scroll (1 standart)
			cardsList.scrollLeft = scrollLeft - walk;
		});

		cardsList.addEventListener('touchstart', (e) => {
			isDown = true;
			cardsList.classList.add('dragging');
			startX = e.touches[0].pageX - cardsList.offsetLeft;
			scrollLeft = cardsList.scrollLeft;
		});

		cardsList.addEventListener('touchend', () => {
			isDown = false;
			cardsList.classList.remove('dragging');
		});

		cardsList.addEventListener('touchmove', (e) => {
			if (!isDown) return;
			const x = e.touches[0].pageX - cardsList.offsetLeft;
			const walk = (x - startX) * 2;
			cardsList.scrollLeft = scrollLeft - walk;
		});

		cardsList.addEventListener('touchmove', (e) => {
			if (isDown) {
				e.preventDefault();
			}
		}, { passive: false });
	}

	// проверка ссылок
	if(!homePage){
		const normalizePath = path => {
			return decodeURIComponent(path)
				.replace(/\/+$/, '') 
				.replace(/#.*$/, '')  
				|| '/';
		};

		const currentPath = normalizePath(window.location.pathname + window.location.hash);
		const linkIs = document.querySelectorAll('.menu_item');

		linkIs.forEach(link => {
			const linkHref = link.getAttribute('href');
			const linkPathname = normalizePath(new URL(linkHref, window.location.origin).pathname);

			if (linkPathname === currentPath) {
				link.classList.add('disabled');
			}
		});
		if ('/события-прошедшие' === currentPath || '/события-прошедшие/' === currentPath || '/события-прошедшие/#' === currentPath) {
			linkIs[1].classList.add('disabled');
		}
		if ('/выставки-прошедшие' === currentPath || '/выставки-прошедшие/' === currentPath || '/выставки-прошедшие/#' === currentPath) {
			linkIs[2].classList.add('disabled');
		}
	}
	// radario fix btn
	document.querySelectorAll(".news_buttons_main").forEach(wrapper => {
		const btnText = wrapper.dataset.btnText;

		wrapper.querySelectorAll(".radario-button").forEach(button => {
			button.classList.add('news__block-btn', 'btn-primary');

			button.innerHTML = `
				${btnText}
				<span class="btn-arrow">
					<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M14.0352 8.4834L9.55273 12.9951L9.05469 13.4932L8.05859 12.4971L8.55664 11.999L11.8379 8.68848H2.16992H1.4668V7.28223H2.16992H11.8379L8.55664 4.00098L8.05859 3.50293L9.05469 2.50684L9.55273 3.00488L14.0352 7.4873L14.5332 7.98535L14.0352 8.4834Z"
							fill="black" />
					</svg>
				</span>
			`;
		});
	});
	// Copy
	console.log(
		"%c Официальный сайт музея: Городок художников на Масловке",
		"background: #000; color: #fff; padding: 10px 10px"
	);
	console.log(
		"%c Разработано в www.rubic-on.com ",
		"background: #000; color: #5598fcff; padding: 10px;"
	);

});
