import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

const storageKey = 'paraiso-dos-mantos-cart';
const readCart = () => JSON.parse(localStorage.getItem(storageKey) || '[]');
const money = value => new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);

window.ParaísoCart = {
    items: readCart(),
    save() {
        localStorage.setItem(storageKey, JSON.stringify(this.items));
        this.render();
    },
    add(product, size = product.sizes?.[0] || 'M') {
        const key = `${product.id}-${size}`;
        const existing = this.items.find(item => item.key === key);
        if (existing) existing.quantity += 1;
        else this.items.push({ ...product, key, size, quantity: 1 });
        this.save();
        this.open();
    },
    remove(key) {
        this.items = this.items.filter(item => item.key !== key);
        this.save();
    },
    render() {
        const count = this.items.reduce((sum, item) => sum + item.quantity, 0);
        const total = this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const countNode = document.querySelector('#cart-count');
        const itemsNode = document.querySelector('#cart-items');
        const totalNode = document.querySelector('#cart-total');
        const emptyNode = document.querySelector('#cart-empty');
        const footerNode = document.querySelector('#cart-footer');
        if (countNode) countNode.textContent = count;
        if (totalNode) totalNode.textContent = money(total);
        if (emptyNode) emptyNode.style.display = this.items.length ? 'none' : 'block';
        if (footerNode) footerNode.style.display = this.items.length ? 'block' : 'none';
        if (itemsNode) itemsNode.innerHTML = this.items.map(item => `<div class="cart-line"><img src="${item.image}" alt="${item.name}"><div><h4>${item.name}</h4><small>Tamanho ${item.size} · ${item.quantity}x</small><strong>${money(item.price * item.quantity)}</strong></div><button class="line-remove" onclick="window.ParaísoCart.remove('${item.key}')">Remover</button></div>`).join('');
    },
    open() {
        document.querySelector('#cart-drawer')?.classList.add('open');
        document.querySelector('#cart-drawer')?.setAttribute('aria-hidden', 'false');
        this.render();
    },
    close() {
        document.querySelector('#cart-drawer')?.classList.remove('open');
        document.querySelector('#cart-drawer')?.setAttribute('aria-hidden', 'true');
    },
    checkout() {
        if (!this.items.length) return;
        const lines = this.items.map(item => `• ${item.name} | tam. ${item.size} | ${item.quantity}x | ${money(item.price * item.quantity)}`).join('\n');
        const total = this.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
        const message = `Olá, Paraíso dos Mantos! Quero finalizar meu pedido:\n\n${lines}\n\nTotal: ${money(total)}\n\nPodem me orientar sobre pagamento e entrega?`;
        window.open(`https://wa.me/5535998135255?text=${encodeURIComponent(message)}`, '_blank', 'noopener');
    }
};

document.addEventListener('DOMContentLoaded', () => {
    window.ParaísoCart.render();
    document.querySelectorAll('.filter').forEach(button => button.addEventListener('click', () => {
        document.querySelectorAll('.filter').forEach(item => item.classList.remove('active'));
        button.classList.add('active');
        const filter = button.dataset.filter;
        document.querySelectorAll('.product-card').forEach(card => { card.style.display = filter === 'all' || card.dataset.category === filter ? '' : 'none'; });
    }));
    document.querySelectorAll('.size-button').forEach(button => button.addEventListener('click', () => { button.parentElement.querySelectorAll('.size-button').forEach(item => item.classList.remove('selected')); button.classList.add('selected'); }));

    const moneyInputs = document.querySelectorAll('[data-money-input]');
    const formatMoneyInput = (input, initial = false) => {
        const raw = input.value.trim();
        if (!raw) {
            input.value = '';
            return;
        }

        let digits;
        if (initial && raw.includes(',')) {
            digits = raw.replace(/\D/g, '');
        } else if (initial && /^\d+\.\d{1,2}$/.test(raw)) {
            digits = raw.replace('.', '');
        } else {
            digits = raw.replace(/\D/g, '');
        }

        if (!digits) {
            input.value = '';
            return;
        }

        input.value = new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        }).format(Number(digits) / 100);
    };

    moneyInputs.forEach(input => {
        formatMoneyInput(input, true);
        input.addEventListener('input', () => formatMoneyInput(input));
        input.addEventListener('blur', () => formatMoneyInput(input));
    });

    const home = document.querySelector('[data-page="store-home"]');
    if (!home) return;

    const motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    const coarsePointer = window.matchMedia('(pointer: coarse)');
    const reducedMotion = () => motionQuery.matches || coarsePointer.matches;
    const revealItems = home.querySelectorAll('.reveal, [data-reveal]');

    home.classList.add('motion-ready');
    const revealAll = () => revealItems.forEach(item => item.classList.add('is-visible'));
    if (motionQuery.matches || !('IntersectionObserver' in window)) {
        revealAll();
    } else {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
        revealItems.forEach(item => observer.observe(item));
    }

    if (!motionQuery.matches) {
        home.classList.add('hero-ready');
    }

    const mantosStage = home.querySelector('[data-mantos-stage]');
    const mantosDisplay = home.querySelector('[data-mantos-display]');
    const mantosImage = home.querySelector('[data-mantos-image]');
    const mantosName = home.querySelector('[data-mantos-name]');
    const mantosTeam = home.querySelector('[data-mantos-team]');
    const mantosPrice = home.querySelector('[data-mantos-price]');
    const mantosThumbs = home.querySelectorAll('[data-mantos-thumb]');

    if (mantosStage && mantosDisplay && mantosImage && mantosName && mantosTeam && mantosPrice) {
        const selectManto = thumb => {
            mantosThumbs.forEach(item => {
                const selected = item === thumb;
                item.classList.toggle('active', selected);
                item.setAttribute('aria-selected', selected ? 'true' : 'false');
            });
            mantosImage.style.opacity = '0';
            window.setTimeout(() => {
                mantosImage.src = thumb.dataset.image;
                mantosImage.alt = thumb.dataset.name;
                mantosName.textContent = thumb.dataset.name;
                mantosTeam.textContent = thumb.dataset.team;
                mantosPrice.textContent = thumb.dataset.price;
                mantosImage.style.opacity = '1';
            }, motionQuery.matches ? 0 : 150);
        };

        mantosThumbs.forEach(thumb => thumb.addEventListener('click', () => selectManto(thumb)));

        if (!reducedMotion()) {
            let frame = 0;
            let bounds = mantosStage.getBoundingClientRect();
            let pointer = { x: 0, y: 0 };
            const resetTilt = () => {
                mantosDisplay.style.setProperty('--tilt-x', '3deg');
                mantosDisplay.style.setProperty('--tilt-y', '-10deg');
            };
            const applyTilt = () => {
                frame = 0;
                const rotateY = ((pointer.x - bounds.left) / bounds.width - 0.5) * 7;
                const rotateX = ((pointer.y - bounds.top) / bounds.height - 0.5) * -5;
                mantosDisplay.style.setProperty('--tilt-x', `${rotateX}deg`);
                mantosDisplay.style.setProperty('--tilt-y', `${rotateY}deg`);
            };
            mantosStage.addEventListener('pointermove', event => {
                if (event.pointerType === 'touch') return;
                pointer = { x: event.clientX, y: event.clientY };
                if (!frame) frame = requestAnimationFrame(applyTilt);
            }, { passive: true });
            mantosStage.addEventListener('pointerleave', resetTilt, { passive: true });
            window.addEventListener('resize', () => { bounds = mantosStage.getBoundingClientRect(); }, { passive: true });
        }
    }

    const parallaxItems = home.querySelectorAll('[data-parallax]');
    if (parallaxItems.length && !reducedMotion()) {
        let frame = 0;
        let pointer = { x: 0, y: 0 };
        const updateParallax = () => {
            frame = 0;
            parallaxItems.forEach(item => {
                const bounds = item.parentElement.getBoundingClientRect();
                const x = ((pointer.x - bounds.left) / bounds.width - 0.5) * 14;
                const y = ((pointer.y - bounds.top) / bounds.height - 0.5) * 10;
                item.style.setProperty('--parallax-x', `${x}px`);
                item.style.setProperty('--parallax-y', `${y}px`);
            });
        };
        home.addEventListener('pointermove', event => {
            if (event.pointerType === 'touch') return;
            pointer = { x: event.clientX, y: event.clientY };
            if (!frame) frame = requestAnimationFrame(updateParallax);
        }, { passive: true });
        home.addEventListener('pointerleave', () => {
            parallaxItems.forEach(item => {
                item.style.setProperty('--parallax-x', '0px');
                item.style.setProperty('--parallax-y', '0px');
            });
        }, { passive: true });
    }
});
