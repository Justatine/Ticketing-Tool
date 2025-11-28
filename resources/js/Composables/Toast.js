import { reactive } from 'vue'

const state = reactive({
  toasts: []
})

export function useToast() {
  const addToast = (toast) => {
    const id = Date.now() + Math.random()
    const newToast = {
      id,
      type: 'info',
      duration: 5000,
      showProgress: true,
      ...toast
    }

    state.toasts.push(newToast)

    return id
  }

  const removeToast = (id) => {
    const index = state.toasts.findIndex(toast => toast.id === id)
    if (index > -1) {
      state.toasts.splice(index, 1)
    }
  }

  const success = (title, message = '', options = {}) => {
    return addToast({
      title,
      message,
      type: 'success',
      ...options
    })
  }

  const error = (title, message = '', options = {}) => {
    return addToast({
      title,
      message,
      type: 'error',
      duration: 0, // Don't auto-close error toasts
      ...options
    })
  }

  const warning = (title, message = '', options = {}) => {
    return addToast({
      title,
      message,
      type: 'warning',
      ...options
    })
  }

  const info = (title, message = '', options = {}) => {
    return addToast({
      title,
      message,
      type: 'info',
      ...options
    })
  }

  const clear = () => {
    state.toasts.splice(0)
  }

  return {
    toasts: state.toasts,
    addToast,
    removeToast,
    success,
    error,
    warning,
    info,
    clear
  }
}
