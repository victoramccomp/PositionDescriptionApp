<template>
  <div class="my-3">

    <!-- loading -->
    <div
      :class="{ 'active': loading }"
      class="canvas">
      <div
        class="spinner-grow text-info"
        role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

  <!-- filters -->
    <div class="container">
      <div class="row">

        <!-- clear -->
        <div class="col-auto">
          <button
            class="btn btn-primary"
            @click.self="resetData"
          >Limpar filtros</button>
        </div>

        <!-- date -->
        <div
          v-if="!hidden.includes('date')"
          class="col-auto">

          <div class="dropdown">

            <!-- dropdown button -->
            <button
              id="dropdownMenuDate"
              class="btn btn-light dropdown-toggle"
              type="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >{{ date.title }}</button>

            <!-- dropdown -->
            <div
              class="dropdown-menu"
              aria-labelledby="dropdownMenuDate">
              <div class="range">

                <!-- options pre -->
                <ul class="range__preoptions">
                  <!-- today -->
                  <li>
                    <a
                      class="dropdown-item"
                      href="#"
                      data-title="Hoje"
                      data-target="date"
                      data-value="1-day"
                      @click.self="updateData"
                    >Hoje</a>
                  </li>

                  <!-- last 7 days -->
                  <li>
                    <a
                      class="dropdown-item"
                      href="#"
                      data-title="Últimos 7 dias"
                      data-target="date"
                      data-value="7-days"
                      @click.self="updateData"
                    >Últimos 7 dias</a>
                  </li>

                  <!-- last 30 days -->
                  <li>
                    <a
                      class="dropdown-item"
                      href="#"
                      data-title="Últimos 30 dias"
                      data-target="date"
                      data-value="30-days"
                      @click.self="updateData"
                    >Últimos 30 dias</a>
                  </li>
                </ul>

                <!-- options custom -->
                <div class="input-group range__custom">
                  <div class="range__custom--group">
                    <label class="range__custom--label">De</label>
                    <input
                      v-model="middlewareDate.start"
                      class="form-control"
                      type="date">
                  </div>
                  <div class="range__custom--group">
                    <label class="range__custom--label">Até</label>
                    <input
                      v-model="middlewareDate.end"
                      class="form-control"
                      type="date">
                  </div>

                  <div class="range__custom--group">
                    <button
                      class="btn btn-primary"
                      :data-title="`${middlewareDate.start} - ${middlewareDate.end}`"
                      data-target="date"
                      data-value="custom"
                      @click.self="updateData"
                    >Aplicar</button>
                  </div>

                </div>

              </div>
            </div>

          </div>

        </div>

        <!-- interviewed -->
        <div
          v-if="hasInterviewed && !hidden.includes('interviewed')"
          class="col-auto">
          <div class="dropdown">

            <!-- dropdown button -->
            <button
              id="dropdownMenuInterviewed"
              class="btn btn-light dropdown-toggle"
              type="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >{{ interviewed.title }}</button>

            <!-- dropdown -->
            <div
              class="dropdown-menu"
              aria-labelledby="dropdownMenuInterviewed">

                <!-- leader option -->
                <a
                  class="dropdown-item"
                  href="#"
                  data-title="Líder"
                  data-target="interviewed"
                  data-value="leader"
                  @click.self="updateData"
                >Líder</a>

                <!-- colaborator option -->
                <a
                  class="dropdown-item"
                  href="#"
                  data-title="Colaborador"
                  data-target="interviewed"
                  data-value="colaborator"
                  @click.self="updateData"
                >Colaborador</a>

                <!-- colaborator option -->
                <a
                  class="dropdown-item"
                  href="#"
                  data-title="Todos"
                  data-target="interviewed"
                  data-value=""
                  @click.self="updateData"
                >Todos</a>

            </div>

          </div>
        </div>

        <!-- directorate -->
        <div
          v-if="directorates.length && !hidden.includes('directorate')"
          class="col-auto">
          <div class="dropdown">

            <button
              id="dropdownMenuDirectorate"
              class="btn btn-light dropdown-toggle"
              type="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >{{ directorate.title }}</button>

            <div
              class="dropdown-menu"
              aria-labelledby="dropdownMenuDirectorate">

              <a
                v-for="(board, indexBoard) in directorates"
                :key="indexBoard"
                :data-title="board.description"
                :data-value="board.id"
                href="#"
                class="dropdown-item"
                data-target="directorate"
                @click.self="updateData"
              >{{ board.description }}</a>

              <a
                data-title="Todos"
                data-value=""
                href="#"
                class="dropdown-item"
                data-target="directorate"
                @click.self="updateData"
              >Todos</a>

            </div>

          </div>
        </div>

        <!-- position-group -->
        <div
          v-if="positionGroups.length && !hidden.includes('position_group')"
          class="col-auto">
          <div class="dropdown">

            <button
              id="dropdownMenuPositionGroup"
              class="btn btn-light dropdown-toggle"
              type="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >{{ positionGroup.title }}</button>

            <div
              class="dropdown-menu"
              aria-labelledby="dropdownMenuPositionGroup">

              <a
                v-for="(group, indexGroup) in positionGroups"
                :key="indexGroup"
                :data-title="group.description"
                :data-value="group.id"
                href="#"
                class="dropdown-item"
                data-target="positionGroup"
                @click.self="updateData"
              >{{ group.description }}</a>

              <a
                data-title="Todos"
                data-value=""
                href="#"
                class="dropdown-item"
                data-target="positionGroup"
                @click.self="updateData"
              >Todos</a>

            </div>
          </div>
        </div>

        <!-- search -->
        <div
          v-if="!hidden.includes('search')"
          class="col">
          <div class="input-group mb-3">

            <!-- search -->
            <input
              v-model.trim="search.value"
              type="search"
              class="form-control"
              placeholder="Buscar por ..."
              aria-label="Buscar por ..."
              aria-describedby="search-button"
              @keyup.enter="submitForm">

            <!-- button search -->
            <div class="input-group-append">
              <button 
                class="btn btn-outline-primary"
                type="button"
                @click.self="submitForm"
              >Buscar</button>
            </div>

          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
const baseData = () => ({
  loading: false,
  route: window.location.pathname,
  middlewareDate: { start: '', end: '' },
  date: { title: 'Qualquer data', value: null, start: null, end: null, paramName: 'date' },
  interviewed: { title: 'Todos', value: null, paramName: 'interviewed' },
  directorate: { title: 'Todos', value: null, paramName: 'directorate' },
  positionGroup: { title: 'Todos', value: null, paramName: 'position_group' },
  search: { value: null, paramName: 'search' },
  queryObject: {}
})

export default {
  name: 'VFilter',

  props: {
    hasInterviewed: {
      type: Boolean,
      required: false,
      default: false
    },
    hasPagination: {
      type: Boolean,
      required: false,
      default: false
    },
    request: {
      type: Object,
      required: false,
      default: () => ({})
    },
    directorates: {
      type: Array,
      required: false,
      default: () => ([])
    },
    positionGroups: {
      type: Array,
      required: false,
      default: () => ([])
    },
    defaultParams: {
      type: Object,
      required: false,
      default: () => ({})
    },
    hidden: {
      type: Array,
      required: false,
      default: () => ([])
    }
  },

  data: function () {
    return baseData()
  },

  computed: {
    query: function () {
      const queryObjectKeys = Object.keys(this.queryObject)
      const queryObjectLength = queryObjectKeys.length

      let search = ''
      let count = 0

      // return null if queryObject data is null
      if (!queryObjectLength) return search

      // loop over queryObject keys
      for (const key of queryObjectKeys) {
        // if queryObject doesn't have a null value
        if (this.queryObject[key]) {
          // mount it into search
          const param = key === 'start' || key === 'end'
            ? this.date.paramName
            : this[key].paramName

          search += `${count++ > 0 ? '&' : '' }${param}=${this.queryObject[key]}`
        }
      }

      // retur the query
      return search
    }
  },

  watch: {
    'date.value': function (value)  {
      switch (value) {
        case '30-days':
          this.date.start = this.formatDate({ flag: 'start', past: 30 }),
          this.date.end = this.formatDate({ flag: 'end' })
          break

        case '7-days':
          this.date.start = this.formatDate({ flag: 'start', past: 7 }),
          this.date.end = this.formatDate({ flag: 'end' })
          break

        case '1-day':
          this.date.start = this.formatDate({ flag: 'start' }),
          this.date.end = this.formatDate({ flag: 'end' })
          break

        case null:
          this.date.start = null
          this.date.end = null
          break

        default:
          this.date.start = this.formatDate({ date: this.middlewareDate.start, flag: 'start' }),
          this.date.end = this.formatDate({ date: this.middlewareDate.end, flag: 'end' })
          break
      }
    },

    'date.start': function (value) {
      if (!value) return this.$delete(this.queryObject, 'start')
      this.$set(this.queryObject, 'start', value)
    },

    'date.end': function (value) {
      if (!value) return this.$delete(this.queryObject, 'end')
      this.$set(this.queryObject, 'end', value)
    },

    'interviewed.value': function (value) {
      if (!value) return this.$delete(this.queryObject, 'interviewed')
      this.$set(this.queryObject, 'interviewed', value)
    },

    'directorate.value': function (value) {
      if (!value) return this.$delete(this.queryObject, 'directorate')
      this.$set(this.queryObject, 'directorate', value)
    },

    'positionGroup.value': function (value) {
      if (!value) return this.$delete(this.queryObject, 'positionGroup')
      this.$set(this.queryObject, 'positionGroup', value)
    },

    'search.value': function (value) {
      if (!value) return this.$delete(this.queryObject, 'search')
      this.$set(this.queryObject, 'search', value)
    }
  },

  created: function () {
    this.fetchData()
  },

  mounted: function () {
    this.hasPagination && this.appendSearchToPagination()
  },

  methods: {
    fetchData: function (resetingDefault = false) {
      const base = Object.assign({}, baseData())
      const defaultParams = this.defaultParams
      const request = resetingDefault
        ? {}
        : this.request

      // register date
      const range = defaultParams.start || request.range && request.range.start
      if (range) {
        const start = range.start.split(' ')[0]
        const end = range.end.split(' ')[0]

        base.date.title = `${start} - ${end}`
        base.middlewareDate.start = start
        base.middlewareDate.end = end
        base.date.value = 'custom'
      }

      // register interviewed
      const interviewed = defaultParams.interviewed || request.interviewed
      if (interviewed) {
        base.interviewed.title = interviewed === 'leader' ? 'Líder' : 'Colaborador'
        base.interviewed.value = interviewed
      }

      // register directorate
      const directorate = defaultParams.directorate || request.directorate
      if (directorate) {
        const item = this.directorates.filter(item => item.id === parseInt(directorate))[0]

        base.directorate.title = item.description
        base.directorate.value = item.id
      }

      // register positionGroup
      const positionGroup = defaultParams.position_group || request.position_group
      if (positionGroup) {
        const item = this.positionGroups.filter(item => item.id === parseInt(positionGroup))[0]

        base.positionGroup.title = item.description
        base.positionGroup.value = item.id
      }

      // register search
      const search = defaultParams.search || request.search
      if (search) { 
        base.search.value = search
      }

      // register data
      Object.assign(this.$data, base)
    },

    updateData: function (e) {
      const target = e.target.dataset.target

      const title = e.target.dataset.title
      const value = e.target.dataset.value

      this[target].title = title
      this[target].value = value
    },

    resetData: async function () {
      await Promise
        .resolve(Object.assign(this.$data, baseData()))
        .then(() => {
          const resetingDefault = true
          this.fetchData(resetingDefault)
        })
    },

    formatDate: function ({ date, flag, past }) {
      const _td = _n => _n < 10 ? `0${_n}` : '' + _n // format date
      const d = date
        ? new Date(date.replace(/(-)/g, ' '))
        : new Date()
      const hour = {
        start: '00:00:00',
        end: '23:59:59'
      }

      if (past) d.setDate(d.getDate() - past)

      return `${d.getFullYear()}-${_td(d.getMonth() + 1)}-${_td(d.getDate())} ${hour[flag]}`
    },

    submitForm: function () {
      const query = this.query

      // redirect
      this.loading = true
      window.location.search = query
    },

    appendSearchToPagination: function () {
      const pagination = document.querySelector('ul.pagination')
      let search = window.location.search || null

      if (!search || !pagination) return

      const links = [...pagination.querySelectorAll('a.page-link')]

      search = search.replace(/(\?)/g, '&').split('&')
      search = search.filter(string => !~string.indexOf('page'))

      for (const link of links) {
        link.href += `${search.join('&')}`
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  $color-border: #ced4da;
  
  .input-group .dropdown {
    border: 1px solid $color-border;
    border-top-right-radius: .25em;
    border-bottom-right-radius: .25em;
  }

  .range {
    display: grid;
    grid-template-columns: auto auto;
    grid-template-rows: 1fr;
    column-gap: 20px;

    &__custom {
      padding: 5px 1.5em 15px 5px;

      &--label {
        margin: {
          bottom: 0;
          right: 10px;
        }
      }

      &--group {
        display: flex;
        align-items: center;

        + [class*='--group'] { margin-top: 15px; }
      }
    }

    &__preoptions {
      position: relative;

      list-style: none;
      padding: 0;
      margin: 0;

      &::before {
        content: '';

        position: absolute;
        top: 50%;
        right: -10px;

        display: block;
        height: 80%;
        width: 1px;
        background-color: $color-border;

        transform: translateY(-50%);
      }
    }
  }
</style>
