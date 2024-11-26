<?php

$step = $_GET['step'] ?? 1;

$percent = 0;
if ($step > 2) {
    $percent = 100;
} elseif ($step > 1) {
    $percent = 65;
} else {
    $percent = 35;
}


?>
<nav class="md:px-12 px-2 md:pt-12 pt-4 lg:hidden block">

    <div class="flex justify-between mb-8">
        <img src="./assets/images/logo.png" width="120px" alt="">

        <div class="flex gap-3">
            <ul class="flex gap-2">
                <li
                    class="md:flex hidden items-center text-header bg-primaryGradient px-4 py-2 rounded-full text-white">
                    <span class="h-2 w-2 bg-white rounded-full mr-2"></span> Get Your Estimate
                </li>
                <li class="flex items-center text-header">
                    <span class="h-2 w-2 bg-primary rounded-full mr-2"></span> +1 346 410 1320
                </li>
            </ul>
            <button id="openMobileNav">
                <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.5 8H25.5" stroke="url(#paint0_linear_16_285)" stroke-width="1.5"
                        stroke-linejoin="round" />
                    <path d="M13.5 14H25.5" stroke="url(#paint1_linear_16_285)" stroke-width="1.5"
                        stroke-linejoin="round" />
                    <path d="M4.5 20H25.5" stroke="url(#paint2_linear_16_285)" stroke-width="1.5"
                        stroke-linejoin="round" />
                    <defs>
                        <linearGradient id="paint0_linear_16_285" x1="4.5" y1="8.5" x2="25.5" y2="8.5"
                            gradientUnits="userSpaceOnUse">
                            <stop stop-color="#0CA3FF" />
                            <stop offset="1" stop-color="#024DBB" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_16_285" x1="13.5" y1="14.5" x2="25.5" y2="14.5"
                            gradientUnits="userSpaceOnUse">
                            <stop stop-color="#0CA3FF" />
                            <stop offset="1" stop-color="#024DBB" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_16_285" x1="4.5" y1="20.5" x2="25.5" y2="20.5"
                            gradientUnits="userSpaceOnUse">
                            <stop stop-color="#0CA3FF" />
                            <stop offset="1" stop-color="#024DBB" />
                        </linearGradient>
                    </defs>
                </svg>
            </button>
        </div>

    </div>

    <div class="mt-3 flex justify-between relative">
        <div class="w-full h-[2px] bg-gray absolute md:top-6 top-4"></div>
        <div class="w-[<?= $percent ?>%] h-[2px] md:hidden block bg-progress absolute top-4"></div>
        <a href="?step=1" class="flex bg-white rounded-xl gap-3 z-10">
            <div
                class="rounded-full <?= $step >= 1 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 <?= $step > 1 ? 'ps-[10px] pt-[5px]' : 'ps-[9px] pt-[5px]' ?> lg:text-sm text-sm my-auto">
                <p><?= $step > 1 ? '<i class="fas fa-check"></i>' : '01' ?></p>
            </div>
            <?php if ($step == 1): ?>
                <div class="md:block hidden text-start">
                    <small class="text-muted">
                        Step 1
                    </small>
                    <h6 class="text-header font-medium">Scope of Work & Photos</h6>
                </div>
            <?php endif; ?>
        </a>
        <a href="?step=2" class="flex bg-white rounded-xl gap-3 z-10">
            <div
                class="rounded-full <?= $step >= 2 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 <?= $step > 2 ? 'ps-[10px] pt-[5px]' : 'ps-[8px] pt-[5px]' ?> lg:text-sm text-sm my-auto">
                <p><?= $step > 2 ? '<i class="fas fa-check"></i>' : '02' ?></p>
            </div>
            <?php if ($step == 2): ?>
                <div class="md:block hidden text-start">
                    <small class="text-muted">
                        Step 2
                    </small>
                    <h6 class="text-header font-medium">Floor Plans</h6>
                </div>
            <?php endif; ?>
        </a>
        <a href="?step=3" class="flex bg-white rounded-xl gap-3 z-10">
            <div
                class="rounded-full <?= $step >= 3 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 <?= $step > 3 ? 'ps-[10px] pt-[5px]' : 'ps-[8px] pt-[5px]' ?> lg:text-sm text-sm my-auto">
                <p><?= $step > 3 ? '<i class="fas fa-check"></i>' : '03' ?></p>
            </div>
            <?php if ($step == 3): ?>
                <div class="md:block hidden text-start">
                    <small class="text-muted">
                        Step 3
                    </small>
                    <h6 class="text-header font-medium">Inspiration Photos</h6>
                </div>
            <?php endif; ?>
        </a>
        <a href="?step=4" class="flex bg-white rounded-xl gap-3 z-10">
            <div
                class="rounded-full <?= $step >= 4 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 <?= $step > 4 ? 'ps-[10px] pt-[5px]' : 'ps-[8px] pt-[5px]' ?> lg:text-sm text-sm my-auto">
                <p><?= $step > 4 ? '<i class="fas fa-check"></i>' : '04' ?></p>
            </div>
            <?php if ($step == 4): ?>
                <div class="md:block hidden text-start">
                    <small class="text-muted">
                        Step 4
                    </small>
                    <h6 class="text-header font-medium">Final</h6>
                </div>
            <?php endif; ?>
        </a>
    </div>
</nav>

<!-- Start Generation Here -->
<nav class="fixed top-0 left-0 w-full bg-white z-30 transition-transform" id="mobileNav">
    <div class="flex justify-between items-center p-4 border-b">
        <img src="./assets/images/logo.png" width="120px" alt="">
        <button id="closeMobileNav" class="text-gray-600">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <ul class="flex flex-col p-4">
        <li class="py-2">
            <a href="" class="text-header">Service</a>
        </li>
        <li class="py-2">
            <a href="" class="text-header">How it works</a>
        </li>
        <li class="py-2">
            <a href="" class="text-header">Project</a>
        </li>
        <li class="py-2">
            <a href="" class="text-header">Company</a>
        </li>
        <li class="py-2">
            <a href="" class="text-header">Contacts</a>
        </li>
        <li class="py-2">
            <a href="" class="text-header">EG Express</a>
        </li>
    </ul>
</nav>
<div class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden" id="mobileNavOverlay"></div>

<script>
    document.getElementById('openMobileNav').addEventListener('click', function() {
        document.getElementById('mobileNav').style.transform = 'translateY(0)';
        document.getElementById('mobileNavOverlay').classList.remove('hidden');
    });

    document.getElementById('closeMobileNav').addEventListener('click', function() {
        document.getElementById('mobileNav').style.transform = 'translateY(-100%)';
        document.getElementById('mobileNavOverlay').classList.add('hidden');
    });

    document.getElementById('mobileNavOverlay').addEventListener('click', function() {
        document.getElementById('mobileNav').style.transform = 'translateY(-100%)';
        document.getElementById('mobileNavOverlay').classList.add('hidden');
    });
    document.getElementById('mobileNav').style.transform = 'translateY(-100%)';
    document.getElementById('mobileNavOverlay').classList.add('hidden');
</script>
<!-- End Generation Here -->