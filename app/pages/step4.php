<div class="2xl:col-span-2 md:col-span-3 col-span-8 md:p-12 p-3 md:pb-3 pb-24">
    <form action="" class="h-full flex flex-col">
        <input type="hidden" name="stage" value="4">
        <div class="mb-8">
            <ul class="mb-4">
                <li class="flex items-center text-muted">
                    <span class="h-2 w-2 bg-primary rounded-full mr-2"></span> Step 4
                </li>
            </ul>
            <h1 class="text-header 2xl:text-4xl lg:text-2xl text-xl font-semibold 2xl:mb-6 mb-3">Personal Data
            </h1>
            <h6 class="text-muted">Let's get started on your project!</h6>
        </div>
        <div id="formStepOne">
            <div class="flex flex-col gap-1 mb-8">
                <label class="text-header">Show us how you would like to see your renovation </label>
                <div class="relative 2xl:mb-6 mb-2">
                    <input type="text" name="name" id="name" required class="bg-white border border-[#DDDDDD] rounded-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent w-full 2xl:p-4 2xl:px-6 p-2 px-4" placeholder="What is your name ?" />
                </div>
                <div class="relative 2xl:mb-6 mb-2">
                    <input type="tel" name="phone" id="phone" required class="bg-white border border-[#DDDDDD] rounded-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent w-full 2xl:p-4 2xl:px-6 p-2 px-4" placeholder="Your phone number*" />
                </div>
                <div class="relative 2xl:mb-6 mb-2">
                    <input type="email" name="email" id="email" required class="bg-white border border-[#DDDDDD] rounded-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent w-full 2xl:p-4 2xl:px-6 p-2 px-4" placeholder="E-mail*" />
                </div>
                <div class="flex md:flex-row flex-col lg:flex-col gap-2">
                    <button
                        class="transition-all duration-150 bg-primaryGradient rounded-full px-6 py-3 text-white">
                        Send
                    </button>
                    <p class="text-muted">
                        By clicking on the button, you consent to the processing of your personal data
                    </p>
                </div>
            </div>
        </div>
        <div
            class="lg:relative mt-auto fixed bottom-0 w-full left-0 lg:p-0 p-4 border-t-2 lg:border-transparent border-gray bg-white">
            <div class="flex w-full items-center lg:pt-5 lg:mt-12 gap-2 ps-6 lg:ps-0">
                <div class="relative w-full">
                    <div class="flex h-[2px] bg-gray rounded">
                        <div id="progressBar" class="bg-progress h-full rounded relative" style="width: 0%;">
                            <div
                                class="bg-primary w-3 h-3 absolute -right-1 -top-1 border-2 border-white rounded-full">

                            </div>
                            <div class="text-xs inline-block text-muted absolute right-0 -top-5">
                                <span id="progressPercent" class="text-xs">0%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end flex gap-1">
                    <button type="button" onclick="window.location.href = '?step=3'"
                        class="transition-all duration-150 bg-white border border-muted rounded-full px-4 py-3 text-header">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>