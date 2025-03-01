<script>
//Inject props
export default {
  extends: "k-toggles-field",
  props: {
    hasImages: Boolean,
    images: {
      type: Object,
      default() {
        return {};
      },
    },
    license: {
      type: Object,
      default() {
        return {};
      },
    },
  },
};
</script>
