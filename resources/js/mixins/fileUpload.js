export default {
    methods: {
        openFileDialog() {
            this.$refs.input.click();
          },
      
          addFile() {
            this.form.image = this.$refs.input.files[0]
          }
    }
}