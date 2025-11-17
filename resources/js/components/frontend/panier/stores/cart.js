

// resources/js/components/frontend/panier/stores/cart.js
import { reactive } from 'vue'

export const cartStore = reactive({
  items: JSON.parse(localStorage.getItem('cart') || '[]'),

  save() {
    localStorage.setItem('cart', JSON.stringify(this.items))
  },

  add(product) {
    const found = this.items.find(i => i.id === product.id)
    if (found) {
      found.quantity += 1
    } else {
      // on clone l'objet pour éviter références indésirables
      this.items.push({ ...product, quantity: 1 })
    }
    this.save()
  },

  increase(item) {
    item.quantity++
    this.save()
  },

  decrease(item) {
    if (item.quantity > 1) item.quantity--
    else {
      const idx = this.items.findIndex(i => i.id === item.id)
      if (idx !== -1) this.items.splice(idx, 1)
    }
    this.save()
  },

  totalItems() {
    return this.items.reduce((s, i) => s + i.quantity, 0)
  },

  totalPrice() {
    return this.items.reduce((s, i) => s + i.prix * i.quantity, 0)
  }
})
