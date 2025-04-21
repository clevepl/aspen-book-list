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

//
import { PanelBody, TextControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * NOTE ABOUT TEXTCONTROL - making this a text string instead of an integer, because gutenberg meltyfaceemoji
 * https://github.com/WordPress/gutenberg/issues/64292
 * https://github.com/WordPress/gutenberg/pull/64293
 * also not using NumberControl because it's still experimental...
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
const BlockEdit = ( props ) => {
	const { attributes, setAttributes } = props;
	const { listID } = attributes;
	const blockProps = useBlockProps();

	return (
		<p { ...useBlockProps() }>
			{ __(
				'Hello! the list contents will display on the front end when you press save',
				'aspen-book-list'
			) }


			<InspectorControls>
				<PanelBody title={ __( 'Aspen List Settings', 'cpl' ) } />
				<TextControl
					__next40pxDefaultSize
					__nextHasNoMarginBottom
					label="List ID"
					help="Insert the LIST ID (only the number)"
					type="string"
					onChange={ ( value ) => setAttributes( { listID: value } ) }
					value={ listID }
				/>
			</InspectorControls>

			{/* { <ServerSideRender block="create-block/aspen-book-list" attributes={attributes} />  } */}
		</p>
	);
};

export default BlockEdit;
