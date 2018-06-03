<template>
  <div class="col-md-6">
    <div class="form-group">
      <label for="autocomplete">Proveedor</label>
      <input type="hidden" name="cardcode" v-model="cardcode">
      <autocomplete
        ref="autocomplete"
        name="provider_cardcode"
        :on-should-get-data="getData"
        anchor="cardname"
        label="cardcode"
        :on-input="onInput"
        :options="autocomplete.options"
        :classes="{ wrapper: 'form-wrapper', input: 'form-control', list: 'data-list', item: 'data-list-item' }"
        :on-select="onSelect"
      >
      </autocomplete>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      oldValue: {
        default: ""
      }
    },
    data() {
      return {
        cardcode: null,
        autocomplete: {
          options: []
        }
      }
    },
    mounted() {
      this.cardcode = this.$refs.autocomplete.type = this.oldValue;
    },
    methods: {
      onInput() {
        this.cardcode = this.$refs.autocomplete.type;
      },
      onSelect(a) {
        this.$refs.autocomplete.type = a.cardcode;
      },
      getData(q) {
        axios.get("/api/providers", {params: {q}})
          .then(res => {
            this.autocomplete.options = res.data.data
          })
      }
    }
  }
</script>
