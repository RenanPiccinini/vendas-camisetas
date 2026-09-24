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

    const mantosStage = document.querySelector('[data-mantos-stage]');
    const mantosDisplay = document.querySelector('[data-mantos-display]');
    const mantosImage = document.querySelector('[data-mantos-image]');
    const mantosName = document.querySelector('[data-mantos-name]');
    const mantosTeam = document.querySelector('[data-mantos-team]');
    const mantosPrice = document.querySelector('[data-mantos-price]');
    const mantosThumbs = document.querySelectorAll('[data-mantos-thumb]');

    if (mantosStage && mantosDisplay && mantosImage && mantosName && mantosTeam && mantosPrice) {
        const selectManto = (thumb) => {
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
            }, 150);
        };

        mantosThumbs.forEach(thumb => thumb.addEventListener('click', () => selectManto(thumb)));

        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            mantosStage.addEventListener('pointermove', event => {
                const bounds = mantosStage.getBoundingClientRect();
                const rotateY = ((event.clientX - bounds.left) / bounds.width - 0.5) * 7;
                const rotateX = ((event.clientY - bounds.top) / bounds.height - 0.5) * -5;
                mantosDisplay.style.transform = `translate(-50%, -50%) rotateY(${rotateY}deg) rotateX(${rotateX}deg)`;
            });
            mantosStage.addEventListener('pointerleave', () => {
                mantosDisplay.style.transform = 'translate(-50%, -50%) rotateY(-10deg) rotateX(3deg)';
            });
        }
    }
});
