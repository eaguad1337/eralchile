<template>
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <ul>
            <li v-for="reviewer of reviewers">
              <span>{{user.name}}</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="form-inline">
        <autocomplete
          :on-should-get-data="findUsers"
          anchor="name"
          label="name"
          :classes="{ wrapper: 'form-wrapper', input: 'form-control', list: 'data-list', item: 'data-list-item' }"
          :on-select="addReviewer">
        </autocomplete>
        <button class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>
</template>

<style>
  ul {
    display: inline-block;
    list-style: none;
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
        reviewers: []
      }
    },
    mounted() {
      this.reviewers = this.defaultReviewers;
    },
    methods: {
      addReviewer(a) {
        console.log(a)
      },
      findUsers(q) {
        axios.get("/api/users")
          .then(res => {
            this.autocomplete.options = res.data
          })
      }
    }
  }
</script>
