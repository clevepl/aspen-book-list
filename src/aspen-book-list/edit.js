/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';

import { useState } from '@wordpress/element';

import { PanelBody, TextControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * NOTE ABOUT TEXTCONTROL - making this a text string instead of an integer, because gutenberg meltyfaceemoji
 * https://github.com/WordPress/gutenberg/issues/64292
 * https://github.com/WordPress/gutenberg/pull/64293
 *
 *
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit() {

		// from https://github.com/WordPress/gutenberg/blob/b17d1cab9be2f531123cbccab8ecd94b87703711/docs/reference-guides/slotfills/plugin-sidebar.md?plain=1#L22
	const [ text, setText ] = useState( '' );

	return (
		<p { ...useBlockProps() }>
			{ __(
				'Aspen Book List – hello from the editor!',
				'aspen-book-list'
			) }

			<InspectorControls>
				<PanelBody title={ __( 'Aspen List Settings', 'cpl' ) } />
				<TextControl
					__next40pxDefaultSize
					__nextHasNoMarginBottom
					label="List ID"
					help="Insert the LIST ID"
					type="string"
					onChange={ ( newText ) => setText( newText ) }
					value=""
				/>
			</InspectorControls>

			{ /* <ServerSideRender block="cpl/podbean" attributes={attributes} /> */ }
		</p>
	);
}
