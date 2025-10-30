<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة شركة مستفيدة جديدة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- ************* نموذج الإرسال الرئيسي ************* --}}
                <form method="POST" action="{{ route('beneficiaries.store_step_1') }}">
                    @csrf

                    {{-- نظام التبويبات (Tabs) --}}
                    <div x-data="{ currentTab: 'basic' }">
                        
                        {{-- قائمة التبويبات --}}
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8 space-x-reverse" aria-label="Tabs">
                                <a href="#" @click.prevent="currentTab = 'basic'" :class="{'border-indigo-500 text-indigo-600': currentTab === 'basic', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'basic'}" class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                    {{ __('1. البيانات الأساسية والمخصصات') }}
                                </a>
                                <a href="#" @click.prevent="currentTab = 'personnel'" :class="{'border-indigo-500 text-indigo-600': currentTab === 'personnel', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'personnel'}" class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                    {{ __('2. المفوض والمندوب (صور و هواتف)') }}
                                </a>
                                <a href="#" @click.prevent="currentTab = 'documents'" :class="{'border-indigo-500 text-indigo-600': currentTab === 'documents', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'documents'}" class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                    {{ __('3. الوثائق والعقود') }}
                                </a>
                            </nav>
                        </div>

                        {{-- محتوى التبويبات --}}
                        <div class="mt-8">
                            
                            {{-- ============================================= --}}
                            {{-- التبويب 1: البيانات الأساسية والمخصصات (basic) --}}
                            {{-- ============================================= --}}
                            <div x-show="currentTab === 'basic'">
                                <h3 class="text-xl font-semibold mb-4 text-gray-700">{{ __('البيانات الأساسية') }}</h3>
                                
                                {{-- هنا سيتم إدخال حقول الشركة الأساسية والمخصصات --}}
                                @include('beneficiaries.partials.basic-details')
                            </div>

                            {{-- ============================================= --}}
                            {{-- التبويب 2: المفوض والمندوب (personnel) --}}
                            {{-- ============================================= --}}
                            <div x-show="currentTab === 'personnel'" style="display: none;">
                                <h3 class="text-xl font-semibold mb-4 text-gray-700">{{ __('بيانات المفوض والمندوب') }}</h3>
                                
                                {{-- هنا سيتم إدخال حقول المفوض والمندوب والصور --}}
                                @include('beneficiaries.partials.personnel-details')
                            </div>

                            {{-- ============================================= --}}
                            {{-- التبويب 3: الوثائق والعقود (documents) --}}
                            {{-- ============================================= --}}
                            <div x-show="currentTab === 'documents'" style="display: none;">
                                <h3 class="text-xl font-semibold mb-4 text-gray-700">{{ __('الوثائق والمستندات') }}</h3>
                                
                                {{-- هنا سيتم إدخال حقول الوثائق وتاريخ الانتهاء --}}
                                @include('beneficiaries.partials.document-upload')
                            </div>

                        </div>

                    </div>
                    
                    {{-- زر الحفظ الرئيسي --}}
                      <div class="flex items-center justify-end mt-6 border-t pt-4">
                        <x-primary-button>
                            {{ __('التالي: بيانات المفوض والمندوب') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>