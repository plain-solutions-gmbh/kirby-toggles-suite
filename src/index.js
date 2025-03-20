import TogglesInput from "@/components/TogglesInput.vue";
import TogglesField from "@/components/TogglesField.vue";
import PlainLicense from "../utils/PlainLicense.vue";

window.panel.plugin("plain/toggles-suite", {
  components: {
    "k-toggles-input": TogglesInput,
    "k-plain-license": PlainLicense,
  },
  fields: {
    toggles: TogglesField,
  },
  icons: {
    alpha:
      '<svg viewBox="0 0 24 24"> <path d="M13.89,16.63H5.97l-0.9,2.09c-0.3,0.75-0.45,1.34-0.45,1.79c0,0.6,0.3,1.05,0.75,1.34c0.3,0.3,1.05,0.45,2.09,0.45v0.6H0 v-0.6c0.75-0.15,1.49-0.45,1.94-1.05s1.19-1.64,1.94-3.29L11.95,0.5h0.3l8.07,18.07c0.75,1.64,1.34,2.84,1.94,3.29 c0.3,0.3,0.9,0.6,1.64,0.6v0.6h-10.9v-0.6h0.45c0.9,0,1.49-0.15,1.79-0.3s0.3-0.45,0.3-0.75c0-0.15,0-0.45-0.15-0.6 c0-0.15-0.15-0.45-0.45-1.19L13.89,16.63z M13.29,15.44l-3.29-7.62l-3.44,7.62H13.29z"/> </svg>',
  },
});
