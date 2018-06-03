<template>
  <div class="row">
    <div class="col-md-12">
      <div class="form-inline">
        <autocomplete
          ref="autocomplete"
          :on-should-get-data="findUsers"
          anchor="name"
          label="email"
          :options="autocomplete.options"
          :classes="{ wrapper: 'form-wrapper', input: 'form-control', list: 'data-list', item: 'data-list-item' }"
          :on-select="setSelectedReviewer"
        >
        </autocomplete>
        <button class="btn btn-primary" :disabled="!$refs.autocomplete || !$refs.autocomplete.type"
                @click="addReviewer">Agregar
        </button>
      </div>

      <div class="row reviewer-list">
        <div class="col-md-12">
          <ul>
            <li v-for="reviewer of reviewers">
              <div>
                <span><strong>{{reviewer.name}}</strong> <{{reviewer.email}}></span>
              </div>
              <div>
                <button class="btn btn-danger" @click="removeReviewer(reviewer)">Quitar</button>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
  .autocomplete-wrapper {
    float: left;
    margin-right: 5px;
  }

  ul {
    padding: 0;
  }

  li {
    display: flex;
  }

  li > div {
    padding: 15px 15px 0 0;
    display: flex;
    align-items: center;
  }
</style>

<script>
  export default {
    name: 'cost-centre-members',
    props: {
      costCentreId: null,
      defaultReviewers: {
        type: Array,
        default: []
      },
    },
    data() {
      return {
        autocomplete: {
          options: []
        },
        selectedReviewer: null,
        reviewers: []
      }
    },
    mounted() {
      this.reviewers = this.defaultReviewers;
    },
    methods: {
      setSelectedReviewer(a) {
        this.$refs.autocomplete.type = a.email;
      },
      addReviewer() {
        const email = this.$refs.autocomplete.type;

        axios.post(`/api/costcentres/${this.costCentreId}/members`, {email})
          .then(res => {
            if (!res.data.success) {
              return swal('', res.data.message, 'info');
            }

            this.reviewers.push(res.data.data);

            return swal('', 'Usuario agregado correctamente.', 'success')
          })
          .catch(err => {
            let message = 'Ocurrió un error inesperado.';

            if (err.response.status === 404) {
              message = 'El usuario con ese email no fue encontrado.'
            }

            swal('', message, 'error');
          })
          .then(() => this.$refs.autocomplete.type = '')
      },
      removeReviewer(reviewer) {
        axios.delete(`/api/costcentres/${this.costCentreId}/members/${reviewer.id}`)
          .then(res => {
            if (res.data.success === false) {
              return swal('', res.data.message, 'info');
            }

            this.reviewers = this.reviewers.filter(r => {
              return r.id !== reviewer.id
            })

            swal('', 'Usuario eliminado correctamente.', 'success')
          })
          .catch(err => {
            return swal('', 'Ha ocurrido un error inesperado.', 'error')
          })
      },
      findUsers(q) {
        axios.get("/api/users", {params: {q}})
          .then(res => {
            this.autocomplete.options = res.data.data
          })
      }
    }
  }
</script>
