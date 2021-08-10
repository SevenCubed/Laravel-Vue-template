<template>
  <Modal :isOpen="!!component" :title="title" @onClose="handleClose">
    <component :is="component" @onClose="handleClose" v-bind="props" />
  </Modal>
</template>

<script>
//https://medium.com/js-dojo/vue-js-manage-your-modal-window-s-effortlessly-using-eventbus-518977195eed
import { EventBus } from '../../js/eventBus'
import Modal from './Modal'
export default {
  data () {
    return {
      component: null,
      title: '',
      props: null
    }
  },
  created () {
    EventBus.$on('open', ({ component, title = '', props = null }) => {
      this.component = component
      this.title = title
      this.props = props
    })
    document.addEventListener('keyup', this.handleKeyup) //For using Escape to close the modal
  },
  beforeDestroy () {
    document.removeEventListener('keyup', this.handleKeyup)
  },
  methods: {
    handleClose () {
      this.component = null
    },
    handleKeyup (e) {
      if (e.keyCode === 27) this.handleClose() //Key 27 = Escape
    }
  },
  components: { Modal },
}
</script>