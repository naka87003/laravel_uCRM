<script setup>
import { ref } from 'vue';
import axios from 'axios';

const emit = defineEmits(['update:customerId']);

const search = ref('');
const customers = ref({});
const isShow = ref(false);
const toggleStatus = () => { isShow.value = !isShow.value };

const searchCustomers = () => {
  axios.get('/api/searchCustomers', {
    params: {
      search: search.value
    }
  })
    .then(res => {
      console.log(res.data)
      customers.value = res.data;
      toggleStatus();
    })
    .catch(error => {
      console.log(error);
    });
}

const setCustomer = e => {
  emit('update:customerId', e.id);
  toggleStatus();
}
</script>
<template>
  <div v-show="isShow" class="modal" id="modal-1" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
      <div class="modal__container w-2/3" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
        <header class="modal__header">
          <h2 class="modal__title" id="modal-1-title">
            顧客選択
          </h2>
          <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close
            @click="toggleStatus"></button>
        </header>
        <main class="modal__content" id="modal-1-content">
          <div v-if="customers" class="w-full mx-auto overflow-auto">
            <table class="table-auto w-full text-left whitespace-no-wrap" style="min-width:600px;">
              <thead>
                <tr>
                  <th
                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                    Id</th>
                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                    名前</th>
                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                    カナ</th>
                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                    電話番号</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="customer in customers.data" :key="customer.id">
                  <td class="border-t-2 border-gray-200 px-4 py-3">
                    <button type="button" class="text-blue-700" @click="setCustomer({ id: customer.id, kana: customer.kana })">
                      {{ customer.id }}
                    </button>
                  </td>
                  <td class="border-t-2 border-gray-200 px-4 py-3">{{ customer.name }}</td>
                  <td class="border-t-2 border-gray-200 px-4 py-3">{{ customer.kana }}</td>
                  <td class="border-t-2 border-gray-200 px-4 py-3">{{ customer.tel }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </main>
        <footer class="modal__footer">
          <button type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window"
            @click="toggleStatus">閉じる</button>
        </footer>
      </div>
    </div>
  </div>
  <div class="flex">
    <input type="text" v-model="search"
      class="rounded-none rounded-s border text-gray-900focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
      placeholder="検索">
    <button type="button" @click="searchCustomers"
      class="inline-flex items-center px-3 text-sm text-white bg-blue-700 border rounded-none border-blue-700 rounded-e dark:bg-blue-600 dark:text-blue-400 dark:border-blue-600">
      <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
      </svg>
    </button>
  </div>
</template>