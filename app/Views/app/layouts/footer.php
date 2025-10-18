<footer class="kt-footer bg-background border-t border-border">
    <div class="kt-container-fixed">
        <div class="flex flex-col lg:flex-row justify-center lg:justify-between items-center gap-3 py-5">
            <!-- Copyright -->
            <div class="flex flex-col sm:flex-row order-2 lg:order-1 gap-1 sm:gap-2 font-normal text-sm text-center lg:text-left">
                <span class="text-secondary-foreground">
                    © <?= date('Y') ?> EduContent Platform
                </span>
                <span class="text-secondary-foreground">
                    Tüm hakları saklıdır.
                </span>
            </div>
            
            <!-- Logo -->
            <div class="flex order-1 lg:order-2 items-center gap-2">
                <img src="<?= base_url('assets/media/app/educontent-emblem.svg') ?>" alt="EduContent Logo" class="h-6 w-auto">
                <span class="text-sm font-medium text-secondary-foreground hidden sm:inline">EduContent Platform</span>
                <span class="text-sm font-medium text-secondary-foreground sm:hidden">EduContent</span>
            </div>
        </div>
        
    </div>
</footer>