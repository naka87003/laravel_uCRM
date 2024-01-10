<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue'
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  item: Object,
  errors: Object
});

const form = ref({
  id: props.item.id,
  name: props.item.name,
  memo: props.item.memo,
  price: props.item.price,
  is_selling: props.item.is_selling
})
const updateItem = id => {
  router.put(route('items.update', { item: id }), form.value)
};
</script>

<template>
  <Head title="商品編集" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品編集</h2>
    </template>
    <section class="text-gray-600 body-font relative">
      <form @submit.prevent="updateItem(form.id)">
        <div class="container px-5 py-8 mx-auto">
          <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                  <input type="text" v-model="form.name" id="name" name="name"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <InputError :message="props.errors.name" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="price" class="leading-7 text-sm text-gray-600">商品価格</label>
                  <input type="number" v-model="form.price" id="price" name="price"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <InputError :message="props.errors.price" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                  <textarea v-model="form.memo" id="memo" name="memo"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                  <InputError :message="props.errors.memo" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="is_selling" class="block leading-7 text-sm text-gray-600">状態</label>
                  <select v-model="form.is_selling" id="is_selling"
                    class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                    <option value="1">販売中</option>
                    <option value="0">停止中</option>
                  </select>
                </div>
              </div>
              <div class="p-2 w-full">
                <button
                  class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </section>
  </AuthenticatedLayout>
</template>
