import Vue from "vue";

//convert to title case
Vue.directive('title-case', {
  bind(el, _, vnode) {
    el.addEventListener('input', (e) => {
      vnode.componentInstance.$emit('input', e.target.value.toLowerCase().replace(/(?:^|\s|-)\S/g, x => x.toUpperCase()))
    })
  },
})


//convert to upper case
Vue.directive('upper-case', {
  bind(el, _, vnode) {
    el.addEventListener('input', (e) => {
      vnode.componentInstance.$emit('input', e.target.value.toUpperCase())
    })
  },
})