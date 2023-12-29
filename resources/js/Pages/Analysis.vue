<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { getToday } from '@/common';
import Chart from '@/Components/Chart.vue';
import ResultTable from '@/Components/ResultTable.vue';

onMounted(() => {
  form.value.startDate = getToday();
  form.value.endDate = getToday();
})

const form = ref({
  startDate: null,
  endDate: null,
  type: 'perDay',
});

const data = ref({});

const getData = async () => {
  await axios.get('/api/analysis/', {
    params: {
      startDate: form.value.startDate,
      endDate: form.value.endDate,
      type: form.value.type
    }
  })
    .then(res => {
      data.value = res.data;
    })
    .catch(error => {
      console.log(error);
    });
}
</script>

<template>
  <Head title="データ分析" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">データ分析</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <section class="text-gray-600 body-font">
              <div class="container px-5 py-8 mx-auto">
                <div class="flex flex-wrap -m-2">
                  <div class="lg:w-2/3 w-full mx-auto">
                    <div class="flex flex-wrap -m-2">
                      <div class="p-2 w-1/2">
                        <div class="relative">
                          <label for="" class="block leading-7 text-sm text-gray-600">開始日</label>
                          <input type="date"
                            class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            name="startDate" v-model="form.startDate">
                        </div>
                      </div>
                      <div class="p-2 w-1/2">
                        <div class="relative">
                          <label for="" class="block leading-7 text-sm text-gray-600">終了日</label>
                          <input type="date"
                            class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            name="endDate" v-model="form.endDate">
                        </div>
                      </div>
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="type" class="block leading-7 text-sm text-gray-600">分析方法</label>
                          <select v-model="form.type" id="type"
                            class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                            <option value="perDay">日別</option>
                            <option value="perMonth">月別</option>
                            <option value="perYear">年別</option>
                            <option value="decile">デシル分析</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <button
                      class="flex ml-auto mt-3 mb-3 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                      @click="getData">分析する</button>
                  </div>
                </div>
                <div v-show="data.data" class="lg:w-2/3 w-full mx-auto overflow-auto">
                  <Chart :data="data" />
                  <ResultTable :data="data" />
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>