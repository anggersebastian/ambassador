import { extend, VeeValidate} from "vee-validate"
import { required, alpha } from "vee-validate/dist/rules"

extend("required", {
  ...required,
  message: "Kolom harus di isi"
})

extend("alpha", {
  ...alpha,
  message: "This field must only contain alphabetic characters"
})