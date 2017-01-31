
.PHONY: all
all:
	@echo 'DynLex Makefile'
	@echo '  make clean        Delete docs and cache files.'
	@echo '  make docs         Generate PHPDocs documentation.'

.PHONY: clear
clean:
	rm -rf docs/

.PHONY: docs
docs: .sami/themes/sami-silentbyte
	./vendor/sami/sami/sami.php update sami.php

.sami/themes/sami-silentbyte:
	git clone https://github.com/SilentByte/sami-silentbyte.git .sami/themes/sami-silentbyte

