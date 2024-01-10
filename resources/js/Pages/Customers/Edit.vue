<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  customer: Object,
  errors: Object
});

const form = ref({
  id: props.customer.id,
  name: props.customer.name,
  kana: props.customer.kana,
  tel: props.customer.tel,
  email: props.customer.email,
  postcode: props.customer.postcode,
  address: props.customer.address,
  birthday: props.customer.birthday,
  gender: props.customer.gender,
  memo: props.customer.memo,
});

const updateCustomer = id => {
  router.put(route('customers.update', { customer: id }), form.value)
};
</script>

<template>
  <Head title="顧客編集" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客編集</h2>
    </template>
    <section class="text-gray-600 body-font relative">
      <form @submit.prevent="updateCustomer(form.id)">
        <div class="container px-5 py-8 mx-auto">
          <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="name" class="leading-7 text-sm text-gray-600">名前</label>
                  <input type="text" v-model="form.name" id="name" name="name"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <InputError :message="props.errors.name" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="kana" class="leading-7 text-sm text-gray-600">カナ</label>
                  <input type="text" v-model="form.kana" id="kana" name="kana"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <InputError :message="props.errors.kana" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                  <input type="tel" v-model="form.tel" id="tel" name="tel"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <InputError :message="props.errors.tel" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                  <input type="email" v-model="form.email" id="email" name="email"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <InputError :message="props.errors.email" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                  <input type="number" v-model="form.postcode" id="postcode" name="postcode"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                    @input="fetchAddress">
                  <InputError :message="props.errors.postcode" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                  <input type="text" v-model="form.address" id="address" name="address"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <InputError :message="props.errors.address" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="birthday" class="leading-7 text-sm text-gray-600">誕生日</label>
                  <input type="date" v-model="form.birthday" id="birthday" name="birthday"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <InputError :message="props.errors.birthday" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="gender" class="block leading-7 text-sm text-gray-600">性別</label>
                  <select v-model="form.gender" id="gender"
                    class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                    <option value="0">男性</option>
                    <option value="1">女性</option>
                    <option value="2">非公開</option>
                  </select>
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
