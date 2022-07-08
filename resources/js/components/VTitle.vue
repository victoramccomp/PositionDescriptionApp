<template>
  <div class="row mt-4 mb-3">
    <div :class="[ url ? 'col-md-7' : 'col' ]">
      <h2>{{ title }}</h2>
    </div>
    <div v-if="url" class="col-md-5">
      <a
        :href="url"
        class="btn btn-primary float-right"
      >{{ call }}</a>
    </div>
</div>
</template>

<script>
export default {
  name: 'VTitle',

  props: {
    title: {
      type: String,
      required: true,
      default: 'Empty'
    },
    url: {
      type: [String, null],
      required: false,
      default: null
    },
    call: {
      type: String,
      required: false,
      default: 'Ir'
    }
  }
}
</script>