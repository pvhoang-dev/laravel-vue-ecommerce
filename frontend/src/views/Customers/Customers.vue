<script setup>
import { ref } from "vue";
import store from "../../store";
import CustomersTable from "./CustomersTable.vue";

const DEFAULT_CUSTOMER = {};
const customerModel = ref({ ...DEFAULT_CUSTOMER });
const showCustomerModal = ref(false);

function showAddNewModal() {
  showCustomerModal.value = true;
}

function editCustomer(c) {
  store.dispatch("getCustomer", c.id).then(({ data }) => {
    // TODO: customer mới bị lỗi do thiếu shipping và billing address
    customerModel.value = data;
    showAddNewModal();
  });
}
</script>

<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Customers</h1>
  </div>
  <CustomersTable @clickEdit="editCustomer" />
</template>
