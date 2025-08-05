import { useState } from "@wordpress/element";
import { Button, TextControl, Spinner, Notice } from "@wordpress/components";
import { useBlockProps, RichText } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();
	const [title, setTitle] = useState("");
	const [loading, setLoading] = useState(false);
	const [error, setError] = useState(null);

	const generateDescription = async () => {
		setLoading(true);
		setError(null);

		try {
			const res = await fetch("/wp-json/adsplugin/v1/generate-description", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
				body: JSON.stringify({ title }),
			});

			const data = await res.json();

			if (res.ok) {
				setAttributes({ description: data.description });
			} else {
				throw new Error(data.message || "Fout bij ophalen beschrijving");
			}
		} catch (err) {
			setError(err.message);
		} finally {
			setLoading(false);
		}
	};

	return (
		<div {...blockProps}>
			<TextControl
				label="Producttitel"
				value={title}
				onChange={(value) => setTitle(value)}
				placeholder="Typ hier de productnaam..."
			/>
			<Button
				variant="primary"
				onClick={generateDescription}
				disabled={loading || !title}
				style={{ marginTop: "10px" }}
			>
				{loading ? <Spinner /> : "Genereer Beschrijving"}
			</Button>

			{error && (
				<Notice status="error" isDismissible>
					{error}
				</Notice>
			)}

			<RichText
				tagName="p"
				value={attributes.description}
				onChange={(value) => setAttributes({ description: value })}
				placeholder="Gegenereerde beschrijving verschijnt hier..."
				style={{ marginTop: "20px" }}
			/>
		</div>
	);
}
