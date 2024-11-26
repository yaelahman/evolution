<div class="lg:col-span-4 col-span-8 md:p-12 p-3">
    <form action="" class="h-full flex flex-col">
        <input type="hidden" name="stage" value="2">
        <div class="mb-8">
            <ul class="mb-4">
                <li class="flex items-center text-muted">
                    <span class="h-2 w-2 bg-primary rounded-full mr-2"></span> Step 2
                </li>
            </ul>
            <h1 class="text-header 2xl:text-4xl lg:text-3xl text-2xl font-semibold mb-6">Floor Plans
            </h1>
            <h6 class="text-muted">Tell us about your project</h6>
        </div>
        <div id="formStepOne">
            <div class="flex flex-col gap-1 mb-8">
                <label class="text-header">Send us your floor plan</label>
                <div
                    class="flex flex-col items-center border border-[#717481] border-opacity-50 border-dashed rounded-xl p-4 py-8">
                    <div class="flex items-center flex-col">
                        <div class="flex gap-2">
                            <i class="fas fa-paperclip text-secondary my-auto"></i>
                            <h6 class="text-header font-medium"><span id="btnUploadStepOne"
                                    class="text-secondary cursor-pointer">Upload</span> Pictures
                                or Videos of the space</h6> <br>
                        </div>
                        <input type="file" accept="image/*,video/*" id="uploadStepOne" class="hidden" />
                        <small class="text-muted">
                            Png, jpeg, pdf format
                        </small>
                    </div>
                </div>
            </div>
            <div id="listUploadedStepOne" class="flex flex-col gap-1">
            </div>
            <div class="flex flex-col gap-1 my-8">
                <div class="flex flex-col">
                    <label class="flex items-center">
                        <input type="checkbox" name="floor_plan" value="1" class="mr-2 h-6 w-6 border border-header">
                        <span class="text-header text-lg">I don't have a floor plans</span>
                    </label>
                </div>
            </div>
        </div>
        <div
            class="lg:relative mt-auto fixed bottom-0 w-full left-0 lg:p-0 p-4 border-t-2 lg:border-transparent border-gray bg-white">
            <div class="flex w-full items-center lg:pt-5 pt-3 lg:mt-12 gap-2 ps-6">
                <div class="relative w-full">
                    <div class="flex h-2 bg-gray rounded">
                        <div id="progressBar" class="bg-progress h-full rounded relative" style="width: 0%;">
                            <div
                                class="bg-primary w-4 h-4 absolute -right-1 -top-1 border-2 border-white rounded-full">

                            </div>
                            <div class=" font-semibold inline-block text-muted absolute right-0 -top-7">
                                <span id="progressPercent">0%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end flex gap-1">
                    <button type="button" onclick="window.location.href = '?step=1'"
                        class="transition-all duration-150 bg-gray rounded-full px-4 py-3 text-header">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button
                        class="transition-all duration-150 bg-primaryGradient rounded-full px-6 py-3 text-white">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>