<template>
  <div></div>
</template>

<script>
export default {
  name: 'VWrite',

  props: {
    request: {
      type: String,
      required: true,
      default: ''
    },
    name: {
      type: String,
      required: true,
      default: 'none'
    }
  },

  mounted() {
    this.writeRequestedData()
  },

  methods: {
    writeRequestedData () {
      window[this.name] = this.request
    }
  }
}
</script>
