ruhoh: ./ruhoh/compiled/
	cd ruhoh && make && cd ..
	cp -Rf ./addition/* ./compiled/

clean:
	rm -rf compiled/*

archives: all
	7z a ./archives/`date +%Y-%m-%d`.7z ./ruhoh/compiled/*

all: ruhoh
