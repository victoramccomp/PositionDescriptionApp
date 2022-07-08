<template>
  <div>

    <!-- loading -->
    <div :class="{ 'active': loading }" class="canvas">
      <div class="spinner-grow text-info" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <!-- page title -->
    <div class="row mb-3 my-5">
      <div class="col-auto">
        <h2>
          <span class="mr-2">Editar Permissões do Usuário:</span>
          <strong>{{ jsonUser.name }}</strong>
        </h2>
      </div>
    </div>

    <!-- alert message -->
    <div
      v-if="'' !== message"
      class="alert alert-success">

      {{ message }}

    </div>

    <!-- row list -->
    <div class="row mt-3">
      <div class="container">

        <div v-for="(filteredRole, key) in filteredRoles" :key="key" class="mb-3">

          <h3>{{ filteredRole.name }}</h3>

          <div class="d-flex">
            <div v-for="(role, keyRole) in filteredRole.roles" :key="keyRole" class="mr-3">

                <input
                  :id="`${filteredRole.key}_${keyRole}`"
                  ref="precheck"
                  v-model="selectedRoles"
                  :value="role.id"
                  :data-checked="getChecked({ id: role.id, key: filteredRole.key })"
                  type="checkbox">

                <label :for="`${filteredRole.key}_${keyRole}`">{{ role.name }}</label>

              </div>
          </div>
        </div>

      </div>
    </div>

    <!-- button salve -->
    <div class="row">
      <div class="container">
        <div class="col-auto d-flex justify-content-center">
          <button
            class="btn btn-primary m-auto"
            @click="sendRoles()"
          >Salvar</button>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
const jQuery = window.$ || window.jQuery

export default {
  name: 'VRoles',

  props: {
    user: {
      type: String,
      required: true,
      default: 'none'
    },

    roles: {
      type: String,
      required: true,
      default: 'none'
    },

    userRoles: {
      type: String,
      required: true,
      default: 'none'
    },

    message: {
      type: String,
      required: false,
      default: ''
    },

    updatePath: {
      type: String,
      required: true,
      default: ''
    }
  },

  data: function () {
    return {
      jsonUser: {},
      jsonRoles: {},
      jsonUserRoles: {},
      filteredRoles: {},
      filteredUserRoles: {},
      selectedRoles: [],
      userId: null,
      title: {
        position_description: 'Descrição da Posição',
        area: 'Área',
        competence: 'Competência',
        competence_level: 'Nível da Competência',
        competence_type: 'Tipo da Competência',
        grade: 'Grau',
        grade_course: 'Curso',
        language: 'Idioma',
        position: 'Posição',
        role: 'Permissão',
        user: 'Usuário',
        directorate: 'Diretoria',
        position_group: 'Grupo da Posição'
      },
      loading: false
    }
  },

  created: function () {
    this.fetchData()
  },

  mounted: async function () {
    this.userId = this.jsonUser.id
    
    await this.updateFilteredUserRoles()
    await this.updateFilteredRoles()

    this.preCheckbox()
  },

  methods: {
    fetchData : function () {
      Object.assign(this.jsonUser, JSON.parse(this.user))
      Object.assign(this.jsonRoles, JSON.parse(this.roles))
      Object.assign(this.jsonUserRoles, JSON.parse(this.userRoles))
    },

    updateFilteredRoles: function () {
      const count = {}

      // fill filteredRoles with data from Lavarel
      for (const jsonRole of Object.values(this.jsonRoles)) {
        // check if key 'screen' from Laravel data
        // exist as an object key in filteredRoles
        if (!this.filteredRoles.hasOwnProperty(jsonRole.screen)) {
          // set count
          count[jsonRole.screen] = 0

          // set 'screen' as an object key for filteredRoles
          // set it's content as a new data
          Vue.set(this.filteredRoles, jsonRole.screen, {})

          // set filteredRoles name
          Vue.set(this.filteredRoles[jsonRole.screen], 'name', this.title[jsonRole.screen])

          // set filteredRoles key for roles validation
          Vue.set(this.filteredRoles[jsonRole.screen], 'key', jsonRole.screen)

          // set filteredRoles roles
          Vue.set(this.filteredRoles[jsonRole.screen], 'roles', [])
        }

        // fill filteredRoles roles
        Vue.set(this.filteredRoles[jsonRole.screen].roles, count[jsonRole.screen]++, { id: jsonRole.id, name: jsonRole.role })
      }
    },

    updateFilteredUserRoles: function () {
      const count = {}

      // fill FilteredUserRoles with data from Lavarel
      for (const jsonUserRole of Object.values(this.jsonUserRoles)) {
        // check if key 'screen' from Laravel data
        // exist as an object key in FilteredUserRoles
        if (!this.filteredUserRoles.hasOwnProperty(jsonUserRole.screen)) {
          // set count
          count[jsonUserRole.screen] = 0

          // set 'screen' as an object key for FilteredUserRoles
          // set it's content as a new data
          Vue.set(this.filteredUserRoles, jsonUserRole.screen, {})

          // set FilteredUserRoles userId
          Vue.set(this.filteredUserRoles[jsonUserRole.screen], 'user_id', jsonUserRole.pivot.user_id)

          // set FilteredUserRoles key for roles validation
          Vue.set(this.filteredUserRoles[jsonUserRole.screen], 'key', jsonUserRole.screen)

          // set FilteredUserRoles roles
          Vue.set(this.filteredUserRoles[jsonUserRole.screen], 'rolesIDs', [])
        }

        // fill FilteredUserRoles roles
        Vue.set(this.filteredUserRoles[jsonUserRole.screen].rolesIDs, count[jsonUserRole.screen]++, jsonUserRole.pivot.role_id)
      }
    },

    getChecked: function ({ id, key }) {
      const checked = !this.filteredUserRoles[key]
        ? false
        : this.filteredUserRoles[key].rolesIDs.includes(id)

      return checked
    },

    preCheckbox: function () {
      for (const input of this.$refs.precheck) {
        if (input.dataset.checked) this.selectedRoles.push(parseInt(input.value))
      }
    },

    sendRoles: function () {
      const form = document.createElement('form')
      const token = document.querySelector('input[name="_token"]')
      const data = {
        _token: token.value,
        user_id: this.userId,
        roles: this.selectedRoles
      }

      // set form data as hidden inputs
      for (const key of Object.keys(data)) {
        const input = document.createElement('input')

        input.setAttribute('type', 'hidden')
        input.setAttribute('name', key)
        input.setAttribute('value', data[key])

        form.appendChild(input)
      }

      // set form params
      form.setAttribute('method', 'POST')
      form.setAttribute('action', this.updatePath)
      
      // embed form into the page
      document.body.appendChild(form)

      // submit
      this.loading = true
      form.submit()
    }
  }
}
</script>
