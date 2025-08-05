import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";
import save from "./save";

registerBlockType("adsplugin/ai-product-description", {
	title: "AI Product Description",
	icon: "edit",
	category: "woocommerce",
	supports: {
		html: false,
	},
	attributes: {
		description: {
			type: "string",
			source: "html",
			selector: "p",
		},
	},
	edit: Edit,
	save,
});
