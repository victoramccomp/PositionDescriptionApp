<template>
  <div>

    <button
      type="submit"
      class="btn btn-primary mb-5 mt-3 mr-auto ml-auto d-block"
      @click="print">{{ title }}</button>

  </div>  
</template>

<script>
export default {
  name: 'VExportPDF',

  props: {
    title: {
      title: String,
      required: false,
      default: 'Exportar PDF'
    }
  },

  methods: {
    print: function () {
      window.print()
    }
  }
}
</script>

<style lang="css" scoped>
  @media print {
    div { display: none; }
  }
</style>
