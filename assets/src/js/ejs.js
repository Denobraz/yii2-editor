const EditorJS = require('@editorjs/editorjs');
const Table = require('@editorjs/table');
const Header = require('@editorjs/header');
const List = require('@editorjs/list');
const Paragraph = require('@editorjs/paragraph');
const Warning = require('@editorjs/warning');
const Delimiter = require('@editorjs/delimiter');
const Quote = require('@editorjs/quote');
const Marker = require('@editorjs/marker');
const RawTool = require('@editorjs/raw');
const Embed = require('@editorjs/embed');
const Checklist = require('@editorjs/checklist');
const ImageTool = require('@editorjs/image');
const LinkTool = require('@editorjs/link');

class eJS {
    constructor(containerId, inputId, uploadFile, uploadUrl, uploadLink) {
        this.uploadFile = uploadFile;
        this.uploadLink = uploadLink;
        this.uploadUrl = uploadUrl;
        this.addRequestData = {};
        this.editors = [];
        this.editor = undefined;

        let meta1 = document.querySelectorAll("meta[name=\"csrf-param\"]");
        let meta2 = document.querySelectorAll("meta[name=\"csrf-token\"]");
        if (meta1.length > 0 && meta2.length > 0) {
            this.addRequestData[meta1[0].content] = meta2[0].content;
        }
        this.start(containerId, inputId);
    }

    get tools() {
        let ejs_tools = {
            header: {
                class: Header,
                shortcut: "CMD+SHIFT+H",
                config: {
                    placeholder: "Enter a header"
                }
            },
            list: {
                class: List,
                inlineToolbar: true,
            },
            paragraph: {
                class: Paragraph,
                inlineToolbar: true,
            },
            warning: {
                class: Warning,
                inlineToolbar: true,
                shortcut: "CMD+SHIFT+W",
                config: {
                    titlePlaceholder: "Title",
                    messagePlaceholder: "Message",
                },
            },
            delimiter: {
                class: Delimiter
            },
            table: {
                class: Table,
                inlineToolbar: true,
                config: {}
            },
            quote: {
                class: Quote,
                inlineToolbar: true,
                shortcut: 'CMD+SHIFT+Q',
                config: {
                    quotePlaceholder: 'Enter a quote',
                    captionPlaceholder: 'Quote\'s author',
                },
            },
            marker: {
                class: Marker,
                shortcut: 'CMD+SHIFT+M',
            },
            raw: {
                class: RawTool,
                config: {
                    placeholder: 'Enter html code',
                }
            },
            embed: {
                class: Embed,
                config: {
                    services: {
                        youtube: true,
                        coub: true,
                    }
                }
            },
            checklist: {
                class: Checklist,
                inlineToolbar: true,
            },
        };
        if (this.uploadFile || this.uploadUrl) {
            ejs_tools["image"] = {
                class: ImageTool,
                config: {
                    endpoints: {},
                    additionalRequestData: this.addRequestData,
                    field: "image",
                    types: "*/*",
                    captionPlaceholder: "Enter caption",
                }
            };
        }
        if (this.uploadFile) {
            ejs_tools["image"].config.endpoints["byFile"] = this.uploadFile;
        }
        if (this.uploadUrl) {
            ejs_tools["image"].config.endpoints["byUrl"] = this.uploadUrl;
        }
        if (this.uploadLink) {
            ejs_tools["linkTool"] = {
                class: LinkTool,
                config: {
                    endpoint: this.uploadLink,
                    additionalRequestData: this.addRequestData,
                }
            };
        }
        return ejs_tools;
    } // end tools

    start(containerId, inputId) {
        var _self = this;
        let e = document.getElementById(containerId);
        if (e) {
            if (!e.dataset.editorjsNum) {
                if (inputId) {
                    var input = document.getElementById(inputId);
                }
                this.editor = new EditorJS({
                    holderId: containerId,
                    tools: this.tools,
                    onChange: () => {
                        if (input) {
                            this.editor.save().then(
                                (output) => {
                                    input.value = JSON.stringify(output);
                                }
                            );
                        }
                    },
                    onReady: () => {
                        if (input) {
                            this.loadJson(input.value);
                        }
                    }
                });
                e.dataset.editorjsNum = 1;
            }
        }
    }

    loadBlocks(blocks) {
        if (this.editor) {
            this.editor.render(blocks);
        }
    }

    loadJson(jsonContent) {
        if (jsonContent) {
            try {
                let data = JSON.parse(jsonContent);
                this.loadBlocks(data);
            } catch (e) {
                console.log("Error load json content", e);
            }
        }
    }
};
module.exports = eJS;